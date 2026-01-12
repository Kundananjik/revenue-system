<?php

use Illuminate\Support\Facades\Route;
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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'));

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
| User Dashboard & Routes (Fixed Redundancy)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Payments
    Route::get('/payments', [UserPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/export/pdf', [UserPaymentController::class, 'exportPdf'])->name('payments.export.pdf');
    Route::get('/payments/export/excel', [UserPaymentController::class, 'exportExcel'])->name('payments.export.excel');

    // Revenue Items
    Route::get('/items', [UserRevenueItemController::class, 'index'])->name('items.index');

    // Penalties
    Route::get('/penalties', [UserPenaltyController::class, 'index'])->name('penalties.index');

    // Profile (Specific User Route)
    Route::get('/profile-settings', [ProfileController::class, 'edit'])->name('profile');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Revenue Management
    Route::resource('categories', RevenueCategoryController::class)->except(['show']);
    Route::resource('items', RevenueItemController::class)->except(['show']);
    Route::resource('payments', AdminPaymentController::class)->except(['show']);
    Route::resource('penalties', AdminPenaltyController::class)->except(['show']);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        // Payments Reports
        Route::get('payments/pdf', [ReportsController::class, 'paymentsPdf'])->name('payments.pdf');
        Route::get('payments/excel', [ReportsController::class, 'paymentsExcel'])->name('payments.excel');

        // Audit Logs Reports (super-admin only)
        Route::middleware('super-admin')->group(function () {
            Route::get('audit-logs/pdf', [ReportsController::class, 'auditLogsPdf'])->name('audit-logs.pdf');
            Route::get('audit-logs/excel', [ReportsController::class, 'auditLogsExcel'])->name('audit-logs.excel');
        });
    });

    // Audit Logs View (super-admin only)
    Route::middleware('super-admin')->group(function () {
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });
});

/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze Defaults)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Breeze Authentication
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';