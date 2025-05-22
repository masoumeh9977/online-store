<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function show(Product $product)
    {
        try {
            $userId = Auth::user()->id;
            $itemCount = $this->cartService->getProductCountInCart($userId, $product->id);
            return view('website.product.show', compact('product', 'itemCount'));
        } catch (\Exception $e) {
            logger()->error($e);
            return BaseResource::error($e->getMessage());
        }
    }
}
