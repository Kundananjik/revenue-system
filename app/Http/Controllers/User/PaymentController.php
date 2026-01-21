<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;

class PaymentController extends Controller
{
    /**
     * Display paginated payments for the logged-in user
     */
    public function index()
    {
        $payments = Payment::with(['payer', 'revenueItem', 'collector'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('user.payments.index', compact('payments'));
    }

    /**
     * Export all payments for the logged-in user to PDF
     */
    public function exportPdf()
    {
        $payments = Payment::with(['payer', 'revenueItem', 'collector'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $pdf = Pdf::loadView('user.payments.pdf', compact('payments'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('my_payments_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Export all payments for the logged-in user to Excel
     */
    public function exportExcel()
    {
        return Excel::download(
            new PaymentsExport(Auth::id()),
            'my_payments_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
