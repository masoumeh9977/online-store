<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Builders\Order\OrderBuilder;

class OrderService
{
    public function buildOrder(array $data): Order
    {
        $builder = new OrderBuilder($data);
        return $builder->build();
    }
}
