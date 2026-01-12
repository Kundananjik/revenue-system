<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth; // Fix 1: Import Auth Facade
use Barryvdh\DomPDF\Facade\Pdf as DomPDF; // Fix 2: Import PDF correctly
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;

class PaymentController extends Controller
{
    /**
     * Display paginated payments for the logged-in user
     */
    public function index()
    {
        // Using Auth::id() instead of auth()->id() often solves IDE warnings
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
                    ->get();

        // Fix 3: Use the imported Alias
        $pdf = DomPDF::loadView('user.payments.pdf', compact('payments'));

        return $pdf->download('my_payments_'.now()->format('Ymd_His').'.pdf');
    }

    /**
     * Export all payments for the logged-in user to Excel
     */
    public function exportExcel()
    {
        // Pass Auth::id() to the export class
        return Excel::download(new PaymentsExport(Auth::id()), 
            'my_payments_'.now()->format('Ymd_His').'.xlsx');
    }
}