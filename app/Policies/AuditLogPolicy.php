<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AuditLog;

class AuditLogPolicy
{
    /**
     * Determine whether the user can view audit logs.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'super-admin';
    }

    /**
     * Optional: viewing a single audit record
     */
    public function view(User $user, AuditLog $auditLog): bool
    {
        return $user->role === 'super-admin';
    }
}
