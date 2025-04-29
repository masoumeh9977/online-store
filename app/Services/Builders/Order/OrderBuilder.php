<?php

namespace App\Services\Builders\Order;

use App\DiscountType;
use App\Models\Order;
use App\Models\Product;
use App\Services\Repositories\DiscountRepository;
use App\Services\Repositories\OrderProductRepository;
use App\Services\Repositories\OrderRepository;
use App\Services\Repositories\ProductRepository;
use Illuminate\Support\Str;

class OrderBuilder implements OrderBuilderInterface
{
    public array $data;
    public Order $order;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setUser()
    {
        $this->data['user_id'] = auth()->user()->id;
        return $this;
    }

    public function setTrackingCode()
    {
        $this->data['tracking_code'] = Str::uuid();
        return $this;
    }


    public function setDiscount(string $code = null)
    {
        $discountRepo = new DiscountRepository();
        if ($code) {
            $discount = $discountRepo->all([
                'code' => $code
            ])->first();
            $this->data['discount_id'] = $discount->id;
        }
        return $this;

    }

    public function setTotalAmount()
    {
        $orderProducts = $this->orderProductRepo->all(['order_id' => $this->order->id]);

        $total = $orderProducts->sum(fn($op) => $op->product->price * $op->quantity);

        if (isset($this->data['discount_id'])) {
            $discount = $this->discountRepo->find($this->data['discount_id']);

            if ($discount) {
                $total -= $discount->type === DiscountType::Percentage->value
                    ? $total * ($discount->value / 100)
                    : $discount->value;
            }
        }
        $this->data['total_amount'] = max($total, 0);
        return $this->data['total_amount'];
    }

    public function setProducts(array $products)
    {
        $prodRepository = new ProductRepository();
        $orderProdRepository = new OrderProductRepository();
        foreach ($products as $product) {
            $fetchedProd = $prodRepository->find($product['id']);
            if ($fetchedProd) {
                $orderProdRepository->create([
                    'product_id' => $product['id'],
                    'order_id' => $this->order->id,
                    'quantity' => $product['quantity']
                ]);
            }
        }
        return $this;
    }


    public function build(): Order
    {
        $this->setUser()
            ->setTrackingCode()
            ->setDiscount($this->data['discount_code'] ?? null);

        $orderRepo = new OrderRepository();
        $this->order = $orderRepo->create($this->data);
        $this->order = $this->order->refresh();
        $this->setProducts($this->data['products'])->setTotalAmount();
        return $this->order;

    }
}
