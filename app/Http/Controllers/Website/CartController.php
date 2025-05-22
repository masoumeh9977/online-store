<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index()
    {
        $cart = $this->cartService->getUnusedCartForUser(Auth::user()->id);
        $items = $cart->items;
        $total = $cart->total_amount;
        return view('website.cart.index', compact('items', 'total'));
    }
}
