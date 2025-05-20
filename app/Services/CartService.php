<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Services\Repositories\ModelRepositories\CartItemRepository;
use App\Services\Repositories\ModelRepositories\CartRepository;

class CartService
{
    public CartRepository $cartRepository;
    public CartItemRepository $cartItemRepository;

    public function __construct()
    {
        $this->cartRepository = new CartRepository();
        $this->cartItemRepository = new CartItemRepository();
    }

    public function addItem($productId, $quantity, $userId)
    {
        try {
            $cart = $this->getUnusedCartForUser($userId);
            $this->cartItemRepository->updateOrCreate(['cart_id' => $cart->id, 'product_id' => $productId], ['quantity' => $quantity]);
        } catch (\Exception $e) {
            logger()->error($e);
            throw new \Exception($e->getMessage());
        }

    }

    public function getUnusedCartForUser($userId)
    {
        $cart = $this->cartRepository->getCartWithoutOrderForUser($userId);
        if (!$cart) {
            $cart = $this->cartRepository->create(['user_id' => $userId]);
        }
        return $cart;
    }

}
