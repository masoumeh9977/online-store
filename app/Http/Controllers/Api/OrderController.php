<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\OrderResource;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

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

    public function getUserOrders(User $user)
    {
        try {
            return OrderResource::collection($user->orders()->latest()->get());
        } catch (\Exception $e) {
            logger()->error($e);
            return BaseResource::error($e->getMessage());
        }
    }
}
