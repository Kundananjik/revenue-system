<?php
namespace App\Exports;

use App\Models\AuditLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping; // Add this

class AuditLogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Eager load user to avoid N+1 issues
        return AuditLog::with('user')->latest()->get();
    }

    // This controls exactly what goes into each row
    public function map($log): array
    {
        return [
            $log->id,
            $log->user->name ?? 'System', // Shows name instead of ID
            $log->action,
            class_basename($log->auditable_type),
            $log->auditable_id,
            $log->ip_address,
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Action',
            'Model',
            'Model ID',
            'IP Address',
            'Date'
        ];
    }
}