<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\MyController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->as('website.')->prefix('')->group(function () {

    Route::get('/', [IndexController::class, 'index'])->name('index');


    //Auth routes
    Route::get('login', [AuthController::class, 'loginIndex'])->name('login.index');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('signup', [AuthController::class, 'signupIndex'])->name('signup.index');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');

    Route::middleware(['auth', 'role.customer'])->as('my.')->prefix('my')->group(function () {
        Route::get('profile', [MyController::class, 'profile'])->name('profile');
        Route::get('orders', [MyController::class, 'orders'])->name('orders');
        Route::get('order/list', [MyController::class, 'getOrdersListAjax'])->name('order.list');
    });

    Route::middleware(['auth', 'role.customer'])->as('user.')->prefix('user')->group(function () {
        Route::post('update', [UserController::class, 'updateUser'])->name('update');
        Route::post('reset/password', [UserController::class, 'resetPassword'])->name('reset.password');
        Route::post('reset/address', [UserController::class, 'resetAddress'])->name('reset.address');
    });

    Route::as('product.')->prefix('product')->group(function () {
        Route::get('{category?}', [ProductController::class, 'index'])->name('index');
        Route::middleware(['auth', 'role.customer'])->get('{product}/show', [ProductController::class, 'show'])->name('show');
    });

    Route::middleware(['auth', 'role.customer'])->as('cart.')->prefix('cart')->group(function () {
        Route::get('', [CartController::class, 'index'])->name('index');
    });

});

Route::middleware(['web', 'auth', 'role.customer'])->as('website.api.v1.')->prefix('website/api/v1/')->group(function () {
    Route::post('product/add', [App\Http\Controllers\Api\CartController::class, 'addItem'])->name('product.add');
    Route::delete('{cartItem}/product/remove', [App\Http\Controllers\Api\CartController::class, 'removeItem'])->name('product.remove');

    Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('{order}/show', [OrderController::class, 'show'])->name('order.show');
});

Route::get('{province}/get-cities', [IndexController::class, 'getCities'])->name('province.get-cities');
