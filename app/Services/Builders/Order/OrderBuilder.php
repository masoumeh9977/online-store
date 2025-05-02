<?php

namespace App\Services\Builders\Order;

use App\DiscountType;
use App\Models\Order;
use App\Services\Repositories\ModelRepositories\CartItemRepository;
use App\Services\Repositories\ModelRepositories\CartRepository;
use App\Services\Repositories\ModelRepositories\DiscountRepository;
use App\Services\Repositories\ModelRepositories\OrderRepository;
use Illuminate\Support\Str;

class OrderBuilder implements OrderBuilderInterface
{
    public array $data;
    public Order $order;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setDiscount(string $code = null): static
    {
        $discountRepo = app(DiscountRepository::class);
        if ($code) {
            $discount = $discountRepo->all([
                'code' => $code
            ])->first();
            $this->data['discount_id'] = $discount->id;
        }
        return $this;
    }

    public function createCart($discountId = null): static
    {
        $cartRepo = app(CartRepository::class);
        $cart = $cartRepo->create(['discount_id' => $discountId]);
        if ($cart) {
            $this->data['cart_id'] = $cart->refresh()->id;
        }
        return $this;
    }

    public function createCartItems(array $products, $cartId): static
    {
        $cartItemRepo = app(CartItemRepository::class);
        foreach ($products as $product) {
            $cartItemRepo->create([
                'cart_id' => $cartId,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
            ]);
        }
        return $this;
    }

    public function calculateTotalAmount($cartId): static
    {
        $cart = (app(CartRepository::class))->find($cartId)?->first();
        $total = $cart?->cartItems->sum(fn($item) => $item->product->price * $item->quantity) ?? 0;
        $this->data['total_amount'] = $total;
        return $this;
    }

    public function calculateDiscountAmount($totalAmount, $discountId = null): static
    {
        $discountAmount = 0;

        if ($discountId) {
            $discount = (app(DiscountRepository::class))->find($discountId)?->first();

            if ($discount) {
                $discountAmount = $discount->type === DiscountType::Fixed->value
                    ? $discount->value
                    : $totalAmount * ($discount->value / 100);
            }
        }
        $this->data['discount_amount'] = $discountAmount;
        return $this;
    }

    public function calculateSubTotalAmount($totalAmount, $discountAmount): static
    {
        $this->data['sub_total_amount'] = ($totalAmount - $discountAmount);
        return $this;
    }

    public function setUser(): static
    {
        $this->data['user_id'] = auth()->user()->id;
        return $this;
    }

    public function setTrackingCode(): static
    {
        $this->data['tracking_code'] = Str::uuid();
        return $this;
    }

    public function storeOrder()
    {
        $orderRepo = app(OrderRepository::class);
        $this->order = $orderRepo->create($this->data);
        return $this->order->refresh();
    }

    public function build(): Order
    {
        return $this->setDiscount($this->data['discount_code'] ?? null)
            ->createCart($this->data['discount_id'] ?? null)
            ->createCartItems($this->data['products'], $this->data['cart_id'])
            ->calculateTotalAmount($this->data['cart_id'])
            ->calculateDiscountAmount($this->data['total_amount'], $this->data['discount_id'] ?? null)
            ->calculateSubTotalAmount($this->data['total_amount'], $this->data['discount_amount'])
            ->setUser()
            ->setTrackingCode()
            ->storeOrder();

    }


}
