<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if (!$user) {
                    break;
                }

                // Admin and Super Admin
                if (in_array($user->role, ['admin', 'super-admin'], true)) {
                    return redirect()->route('admin.dashboard');
                }

                // Collector
                if ($user->role === 'collector') {
                    return redirect()->route('collector.dashboard');
                }

                // Normal user
                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
