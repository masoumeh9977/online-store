<?php

namespace App\Models;

use App\DiscountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    protected $fillable = [
      'code',
      'type', //percentage or fixed
      'value',
      'max_usage',
      'used_count',
      'expires_at',
      'is_active',
    ];

    protected $casts = [
        'type' => DiscountType::class,
        'expires_at' => 'datetime',
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discount_code_users')
            ->withTimestamps();
    }

    public function discountUsers(): HasMany
    {
        return $this->hasMany(DiscountCodeUser::class);
    }

}
