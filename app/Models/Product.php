<?php

namespace App\Models;

use App\HasMediaTrait;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasMediaTrait;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'description',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
