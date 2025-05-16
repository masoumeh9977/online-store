<?php

use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\MyController;
use App\Http\Controllers\Website\UserController;
use Illuminate\Support\Facades\Route;

Route::as('website.')->prefix('')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('orders', [IndexController::class, 'orders']);


    Route::get('login', [AuthController::class, 'loginIndex'])->name('login.index');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('signup', [AuthController::class, 'signupIndex'])->name('signup.index');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');

    Route::as('my.')->prefix('my')->group(function () {
        Route::get('profile', [MyController::class, 'profile'])->name('profile');
    });

    Route::as('user.')->prefix('user')->group(function () {
        Route::post('update', [UserController::class, 'updateUser'])->name('update');
        Route::post('reset/password', [UserController::class, 'resetPassword'])->name('reset.password');
        Route::post('reset/address', [UserController::class, 'resetAddress'])->name('reset.address');
    });

});
Route::get('{province}/get-cities', [IndexController::class, 'getCities'])->name('province.get-cities');
