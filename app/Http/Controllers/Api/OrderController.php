<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
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

    public function show(Order $order)
    {
        try {
            return new OrderResource($order);
        } catch (\Exception $e) {
            logger()->info($e);
            return BaseResource::error($e->getMessage());
        }
    }

}
