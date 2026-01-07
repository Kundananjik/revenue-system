<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\AuditLog;
use App\Models\RevenueItem;
use App\Models\Payment;

use App\Policies\UserPolicy;
use App\Policies\AuditLogPolicy;

use App\Observers\RevenueItemObserver;
use App\Observers\PaymentObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register policies (Laravel 11 way)
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(AuditLog::class, AuditLogPolicy::class);

        // Register observers
        RevenueItem::observe(RevenueItemObserver::class);
        Payment::observe(PaymentObserver::class);

        // Optional pagination styling
        // Paginator::useTailwind();
    }
}
