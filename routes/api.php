<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::as('api.v1.')->prefix('v1/')->group(function () {
    Route::post('product/add', [CartController::class, 'addItem'])->name('product.add');

    Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('{user}/orders', [OrderController::class, 'getUserOrders'])->name('orders.list');
});
