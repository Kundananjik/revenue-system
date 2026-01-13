<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate credentials
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt login with "remember me"
        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // 3. Regenerate session to prevent fixation
        $request->session()->regenerate();

        // 4. Get authenticated user
        $user = Auth::user();

        // 5. Redirect based on role
$user = Auth::user();

switch ($user->role) {
    case 'super-admin':
    case 'admin':
        return redirect()->route('admin.dashboard');
    case 'user':
        return redirect()->route('user.dashboard');
    case 'collector':
        return redirect()->route('collector.dashboard');
    default:
        return redirect('/'); // fallback
}
    }
    /**
     * Log out the user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
