<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuditLogController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', AuditLog::class);

        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.audit-logs.index', compact('logs'));
    }
}
