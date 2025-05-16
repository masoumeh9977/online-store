<?php

namespace App\Services\Facades;


use App\Services\OrderStatusRenderer;
use Illuminate\Support\Facades\Facade;

class OrderStatusHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OrderStatusRenderer::class;
    }
}
