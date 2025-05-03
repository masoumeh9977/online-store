<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::as('api.v1.')->prefix('v1/')->group(function (){
    Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
});
