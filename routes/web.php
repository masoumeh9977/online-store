<?php

use App\Http\Controllers\Website\IndexController;
use Illuminate\Support\Facades\Route;

Route::as('website')->prefix('')->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::get('orders', [IndexController::class, 'orders']);

});
