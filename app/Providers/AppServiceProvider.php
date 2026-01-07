<?php

namespace App\Providers;

use App\Models\RevenueItem;
use App\Observers\RevenueItemObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        // Registering the RevenueItem Observer
        RevenueItem::observe(RevenueItemObserver::class);

        // Registering the Payment Observer
        \App\Models\Payment::observe(\App\Observers\PaymentObserver::class);

        // Optional: If you use Tailwind for pagination (default in L11)
        // Paginator::useTailwind();
    }
}