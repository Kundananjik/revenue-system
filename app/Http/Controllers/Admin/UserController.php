<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', User::class);

        return view('admin.users.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:user,collector,admin',
            'password' => 'required|min:8',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        AuditLog::create([
            'user_id'        => Auth::id(), // FIXED
            'action'         => 'created user',
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
            'new_values'     => [
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully');
    }
}
