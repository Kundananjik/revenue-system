<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  <-- This can now accept multiple roles separated by '|'
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Convert the pipe-separated roles into an array
        $allowedRoles = explode('|', $roles);

        // Check if the user's role is in the allowed roles
        if (!in_array($request->user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized. This area is restricted to ' . implode(', ', $allowedRoles) . '.');
        }

        return $next($request);
    }
}
