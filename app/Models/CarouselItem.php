<?php

namespace App\Models;

use App\HasMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CarouselItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasMediaTrait;

    protected $fillable = [
      'title',
      'text'
    ];
}
