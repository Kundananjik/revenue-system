<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Using string format to avoid "Undefined type" errors during setup
        $middleware->alias([
            'admin'       => 'App\Http\Middleware\AdminMiddleware',
            'super-admin' => 'App\Http\Middleware\SuperAdminMiddleware',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();