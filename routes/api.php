<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->as('api.v1.')->prefix('v1/')->group(function () {
    Route::get('product/fetch/{category?}', [ProductController::class, 'fetch'])->name('product.fetch');
    Route::middleware(['auth:sanctum', 'role.customer'])->post('product/add', [CartController::class, 'addItem'])->name('product.add');
    Route::middleware(['auth:sanctum', 'role.customer'])->delete('{cartItem}/product/remove', [CartController::class, 'removeItem'])->name('product.remove');

    Route::middleware(['auth:sanctum', 'role.customer'])->post('order/store', [OrderController::class, 'store'])->name('order.store');
    Route::middleware(['auth:sanctum', 'role.customer'])->get('{order}/show', [OrderController::class, 'show'])->name('order.show');
});
