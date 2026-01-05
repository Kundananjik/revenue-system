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
                $user = Auth::user();

                // Redirect based on role
                if ($user->role === 'admin' || $user->role === 'super-admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
