<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $service = new OrderService();
            $order = $service->buildOrder($request->all());
            return BaseResource::success($order);
        } catch (\Exception $e) {
            logger()->info($e);
            return BaseResource::error($e->getMessage());
        }
    }
}
