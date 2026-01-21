<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\AuditLog;
use App\Exports\PaymentsExport;
use App\Exports\AuditLogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportsController extends Controller
{
    use AuthorizesRequests;

    public function paymentsPdf()
    {
        $this->authorize('viewAny', Payment::class);

        $payments = Payment::with(['payer','revenueItem','collector'])->latest()->get();

        $pdf = Pdf::loadView('admin.reports.payments_pdf', compact('payments'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('payments-report.pdf');
    }

public function paymentsExcel()
{
    $this->authorize('viewAny', Payment::class);

    // exports ALL payments
    return Excel::download(new PaymentsExport(), 'payments-report.xlsx');
}

    public function auditLogsPdf()
    {
        $this->authorize('viewAny', AuditLog::class);

        $logs = AuditLog::with('user')->latest()->get();

        $pdf = Pdf::loadView('admin.reports.audit_logs_pdf', compact('logs'));

        return $pdf->download('audit-logs-report.pdf');
    }

    public function auditLogsExcel()
    {
        $this->authorize('viewAny', AuditLog::class);

        return Excel::download(new AuditLogsExport(), 'audit-logs-report.xlsx');
    }
}
