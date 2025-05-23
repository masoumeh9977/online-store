<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::as('api.v1.')->prefix('v1/')->group(function () {
    Route::get('product/fetch', [ProductController::class, 'fetch'])->name('product.fetch');
    Route::post('product/add', [CartController::class, 'addItem'])->name('product.add');
    Route::delete('{cartItem}/product/remove', [CartController::class, 'removeItem'])->name('product.remove');

    Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('{order}/show', [OrderController::class, 'show'])->name('order.show');
});
