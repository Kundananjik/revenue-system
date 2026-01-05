<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // ONLY allow 'super-admin'
        if (!$user || $user->role !== 'super-admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Super Admin privileges required for this action.');
        }

        return $next($request);
    }
}