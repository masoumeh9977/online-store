<?php

namespace App\Observers;

use App\Models\CartItem;
use App\Services\Repositories\ModelRepositories\CartRepository;
use Illuminate\Support\Str;

class CartItemObserver
{
    public function __construct(protected CartRepository $cartRepository)
    {
    }

    public function deleting(CartItem $item)
    {
        $cart = $item->cart;
        if (!(count($cart->items) > 1)) {
            $this->cartRepository->delete($cart->id);
        }
    }

}
