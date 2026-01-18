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

public function edit(User $user)
{
    $this->authorize('update', $user);

    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $this->authorize('update', $user);

    $data = $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role'  => 'required|in:user,collector,admin,super-admin',
        'password' => 'nullable|min:8',
    ]);

    // Only update password if provided
    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    // Optional: capture old values for audit
    $old = $user->only(['name', 'email', 'role']);

    $user->update($data);

    AuditLog::create([
        'user_id'        => Auth::id(),
        'action'         => 'updated user',
        'auditable_type' => User::class,
        'auditable_id'   => $user->id,
        'old_values'     => $old,
        'new_values'     => $user->only(['name', 'email', 'role']),
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
}

public function destroy(User $user)
{
    $this->authorize('delete', $user);

    $old = $user->only(['name', 'email', 'role']);

    $user->delete();

    AuditLog::create([
        'user_id'        => Auth::id(),
        'action'         => 'deleted user',
        'auditable_type' => User::class,
        'auditable_id'   => $user->id,
        'old_values'     => $old,
        'new_values'     => null,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
}
}