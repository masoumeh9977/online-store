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
        'discount_amount',
        'total_amount',
        'shipping_address',
        'cart_id',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
