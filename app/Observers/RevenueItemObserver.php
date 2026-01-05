<?php

namespace App\Observers;

use App\Models\RevenueItem;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RevenueItemObserver
{
    public function created(RevenueItem $item)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'auditable_type' => get_class($item),
            'auditable_id' => $item->id,
            'new_values' => $item->toArray(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }

    public function updated(RevenueItem $item)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'auditable_type' => get_class($item),
            'auditable_id' => $item->id,
            'old_values' => $item->getOriginal(),
            'new_values' => $item->getChanges(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }

    public function deleted(RevenueItem $item)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'auditable_type' => get_class($item),
            'auditable_id' => $item->id,
            'old_values' => $item->toArray(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
