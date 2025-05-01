<?php

namespace App\Models;

use App\Observers\OrderObserver;
use App\OrderStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'tracking_code',
        'status',
        'total_amount',
        'shipping_address',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

}
