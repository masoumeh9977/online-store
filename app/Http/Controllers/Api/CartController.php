<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\StoreCartItemRequest;
use App\Http\Resources\BaseResource;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function addItem(StoreCartItemRequest $request)
    {
        try {
            $userId = Auth::user()?->id;
            $this->cartService
                ->addItem($request->input('product_id'), $request->input('quantity'), $userId);
            return BaseResource::success([], 'Added to cart successfully');
        } catch (\Exception $e) {
            logger()->info($e);
            return BaseResource::error($e->getMessage());
        }
    }

    public function removeItem(CartItem $cartItem)
    {
        try {
            $this->cartService->removeItem($cartItem);
            return BaseResource::success([], 'Item removed successfully');
        } catch (\Exception $e) {
            logger()->info($e);
            return BaseResource::error($e->getMessage());
        }
    }
}
