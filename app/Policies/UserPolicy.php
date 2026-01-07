<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // allow admin or super-admin
        return in_array($user->role, ['admin', 'super-admin']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'super-admin']);
    }

    public function update(User $user, User $model)
    {
        return in_array($user->role, ['admin', 'super-admin']);
    }

    public function delete(User $user, User $model)
    {
        return $user->role === 'super-admin';
    }
}
