<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
    
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Admin Controllers
use App\Http\Controllers\Admin\RevenueCategoryController;
use App\Http\Controllers\Admin\RevenueItemController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PenaltyController as AdminPenaltyController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\UserController;

// User Controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\RevenueItemController as UserRevenueItemController;
use App\Http\Controllers\User\PenaltyController as UserPenaltyController;

// Collector Controllers
use App\Http\Controllers\Collector\CollectorController;
use App\Http\Controllers\Collector\CollectorPaymentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Global Dashboard (fixes: Route [dashboard] not defined)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user instanceof User) {
        return redirect()->route('login');
    }

    if ($user->isSuperAdmin() || $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isCollector()) {
        return redirect()->route('collector.dashboard');
    }

    if (! $user->hasVerifiedEmail()) {
        return redirect()->route('verification.notice');
    }

    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');
/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [UserPaymentController::class, 'index'])->name('index');
            Route::get('export/pdf', [UserPaymentController::class, 'exportPdf'])->name('export.pdf');
            Route::get('export/excel', [UserPaymentController::class, 'exportExcel'])->name('export.excel');
        });

        Route::get('items', [UserRevenueItemController::class, 'index'])->name('items.index');
        Route::get('penalties', [UserPenaltyController::class, 'index'])->name('penalties.index');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

/*
|--------------------------------------------------------------------------
| Collector Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:collector'])
    ->prefix('collector')
    ->name('collector.')
    ->group(function () {

        Route::get('dashboard', [CollectorController::class, 'dashboard'])->name('dashboard');

        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [CollectorPaymentController::class, 'index'])->name('index');
            Route::get('create', [CollectorPaymentController::class, 'create'])->name('create');
            Route::post('/', [CollectorPaymentController::class, 'store'])->name('store');
            Route::get('{payment}', [CollectorPaymentController::class, 'show'])->name('show');
            Route::get('{payment}/edit', [CollectorPaymentController::class, 'edit'])->name('edit');
            Route::put('{payment}', [CollectorPaymentController::class, 'update'])->name('update');
            Route::get('export/pdf', [CollectorPaymentController::class, 'exportPdf'])->name('export.pdf');
        });

        Route::get('revenue-items', [CollectorController::class, 'revenueItems'])->name('revenue.items');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|super-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', fn () => view('admin.dashboard'))->name('dashboard');

        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('categories', RevenueCategoryController::class)->except(['show']);
        Route::resource('items', RevenueItemController::class)->except(['show']);
        Route::resource('payments', AdminPaymentController::class)->except(['show']);
        Route::resource('penalties', AdminPenaltyController::class)->except(['show']);

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('payments/pdf', [ReportsController::class, 'paymentsPdf'])->name('payments.pdf');
            Route::get('payments/excel', [ReportsController::class, 'paymentsExcel'])->name('payments.excel');

            Route::middleware('role:super-admin')->group(function () {
                Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
                Route::get('audit-logs/pdf', [ReportsController::class, 'auditLogsPdf'])->name('audit-logs.pdf');
                Route::get('audit-logs/excel', [ReportsController::class, 'auditLogsExcel'])->name('audit-logs.excel');
            });
        });
    });

/*
|--------------------------------------------------------------------------
| Breeze Auth
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
