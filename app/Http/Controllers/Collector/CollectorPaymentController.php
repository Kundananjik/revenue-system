<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CollectorPaymentController extends Controller
{

    /**
     * Display a paginated list of payments collected by the logged-in collector.
     */
    public function index()
    {
        $payments = Payment::where('collected_by', Auth::id())
            ->with(['revenueItem', 'payer'])
            ->latest('paid_at')
            ->paginate(10);

        return view('collector.payments.index', compact('payments'));
    }

    /**
     * Export payments collected by the logged-in collector to PDF.
     */
    public function exportPdf()
    {
        $payments = Payment::where('collected_by', Auth::id())
            ->with(['revenueItem', 'payer'])
            ->latest('paid_at')
            ->get();

        $pdf = Pdf::loadView('collector.reports.payments_pdf', compact('payments'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('collector-payments-report.pdf');
    }
}
