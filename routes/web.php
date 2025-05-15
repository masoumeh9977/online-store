<?php

use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\IndexController;
use Illuminate\Support\Facades\Route;

Route::as('website.')->prefix('')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('orders', [IndexController::class, 'orders']);


    Route::get('login', [AuthController::class, 'loginIndex'])->name('login.index');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});
