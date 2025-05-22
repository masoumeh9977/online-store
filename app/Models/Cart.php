<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')
            ->withPivot('quantity');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum(fn($item) => $item->total_item_price);
    }
}
