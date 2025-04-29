<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderObserver
{
    public function creating(Order $order)
    {
        if (!isset($order->tracking_code)) {
            $order->tracking_code = Str::uuid();
        }
    }
}
