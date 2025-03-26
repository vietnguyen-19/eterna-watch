<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Relation::morphMap([
            'post' => 'App\Models\Post',
            'product' => 'App\Models\Product',
            'order' => 'App\Models\Order',
            'payment' => 'App\Models\Payment',
            'shipment' => 'App\Models\Shipment',
        ]);
    }
}
