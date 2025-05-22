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
        $items = $this->cartService->getUnusedCartForUser(Auth::user()->id)->items;
        return view('website.cart.index', compact('items'));
    }
}
