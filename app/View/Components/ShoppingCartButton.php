<?php

namespace App\View\Components;

use App\Services\CartService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ShoppingCartButton extends Component
{
    public int $cartItemCount;

    /**
     * Create a new component instance.
     */
    public function __construct(protected CartService $cartService, int $cartItemCount = 0)
    {
        $this->cartItemCount = $cartItemCount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->cartItemCount = $this->cartService->getUnusedCartForUser(Auth::user()->id)->items->count();
        return view('components.shopping-cart-button');
    }
}
