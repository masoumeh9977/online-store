<?php

namespace App\Providers;

use App\Services\Repositories\ModelRepositories\CartItemRepository;
use App\Services\Repositories\ModelRepositories\CartRepository;
use App\Services\Repositories\ModelRepositories\DiscountRepository;
use App\Services\Repositories\ModelRepositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletonRepositories = [
            DiscountRepository::class,
            CartRepository::class,
            CartItemRepository::class,
            OrderRepository::class,
        ];

        foreach ($singletonRepositories as $repository) {
            $this->app->singleton($repository);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
