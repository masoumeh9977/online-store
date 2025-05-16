<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\BaseResource;
use App\Models\Product;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function show(Product $product)
    {
        try {
            return view('website.product.show', compact('product'));
        } catch (\Exception $e) {
            logger()->error($e);
            return BaseResource::error($e->getMessage());
        }
    }
}
