<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // 1. Check if user is logged in
        // 2. Allow if user is 'admin' OR 'super-admin'
        if (!$user || !in_array($user->role, ['admin', 'super-admin'])) {
            // Option A: Hard block
            // abort(403, 'Unauthorized access.');

            // Option B: Redirect to user dashboard with an error (Recommended)
            return redirect()->route('dashboard')->with('error', 'You do not have administrative access.');
        }

        return $next($request);
    }
}