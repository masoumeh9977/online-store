<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\BaseResource;
use App\Services\OrderService;
use App\Services\ProductService;

class IndexController extends Controller
{
    public function index(ProductService $service)
    {
        $products = $service->getLatestItems(4);
        return view('website.index', compact('products'));
    }
}
