<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\RevenueCategoryController;
use App\Http\Controllers\Admin\RevenueItemController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PenaltyController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (SECURED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // User Management (Admins)
        Route::resource('users', UserController::class)->except(['show']);

        // Revenue Resources
        Route::resource('categories', RevenueCategoryController::class)->except(['show']);
        Route::resource('items', RevenueItemController::class)->except(['show']);
        Route::resource('payments', PaymentController::class)->except(['show']);
        Route::resource('penalties', PenaltyController::class)->except(['show']);

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {

            Route::get('payments/pdf', [ReportsController::class, 'paymentsPdf'])
                ->name('payments.pdf');

            Route::get('payments/excel', [ReportsController::class, 'paymentsExcel'])
                ->name('payments.excel');

            Route::middleware(['super-admin'])->group(function () {
                Route::get('audit-logs/pdf', [ReportsController::class, 'auditLogsPdf'])
                    ->name('audit-logs.pdf');

                Route::get('audit-logs/excel', [ReportsController::class, 'auditLogsExcel'])
                    ->name('audit-logs.excel');
            });
        });

        // Audit Logs (Super Admin only)
        Route::middleware(['super-admin'])->group(function () {
            Route::get('audit-logs', [AuditLogController::class, 'index'])
                ->name('audit-logs.index');
        });
    });

/*
|--------------------------------------------------------------------------
| Regular User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze/Default)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';