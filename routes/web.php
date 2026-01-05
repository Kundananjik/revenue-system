<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RevenueCategoryController;
use App\Http\Controllers\Admin\RevenueItemController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PenaltyController;
use App\Http\Controllers\Admin\AuditLogController;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (SECURED) - Place BEFORE regular user routes
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

        // Revenue Resources
        Route::resource('categories', RevenueCategoryController::class)->except(['show']);
        Route::resource('items', RevenueItemController::class)->except(['show']);
        Route::resource('payments', PaymentController::class)->except(['show']);
        Route::resource('penalties', PenaltyController::class)->except(['show']);

        // Audit Logs (SUPER ADMIN ONLY)
        Route::middleware(['super-admin'])->group(function () {
            Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        });
    });

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Regular Users)
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
| Auth Routes (Breeze defaults)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';