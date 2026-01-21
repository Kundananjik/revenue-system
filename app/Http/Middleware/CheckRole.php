<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $allowedRoles = preg_split('/[,\|]/', $roles);
        $allowedRoles = array_values(array_filter(array_map('trim', $allowedRoles)));

        $role = Auth::user()->role; // <-- no $request->user()

        if (!in_array($role, $allowedRoles, true)) {
            abort(403, 'Unauthorized. This area is restricted to ' . implode(', ', $allowedRoles) . '.');
        }

        return $next($request);
    }
}
