<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\RevenueItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;


class CollectorPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->where('collected_by', Auth::id())
            ->with(['revenueItem', 'payer', 'collector'])
            ->latest()
            ->paginate(10);

        return view('collector.payments.index', compact('payments'));
    }

public function create(Request $request)
{
    $payers = User::query()
        ->whereIn('role', ['user', 'citizen'])
        ->orderBy('name')
        ->get(['id', 'name', 'email']);

    $items = RevenueItem::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get(['id', 'name']);

    $selectedItemId = $request->query('item_id');

    return view('collector.payments.create', compact('payers', 'items', 'selectedItemId'));
}

    public function store(Request $request)
    {
        $this->normalizeNullableInputs($request);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'revenue_item_id' => ['required', 'exists:revenue_items,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,paid,failed,reversed'],
            'reference' => ['nullable', 'string', 'max:255', 'unique:payments,reference'],
            'transaction_details' => ['nullable', 'array'],
        ]);

        $payer = User::query()
            ->where('id', $data['user_id'])
            ->whereIn('role', ['user', 'citizen'])
            ->first();

        if (!$payer) {
            abort(403, 'Only user or citizen accounts can be billed.');
        }

        $payment = new Payment();
        $payment->user_id = $data['user_id'];
        $payment->revenue_item_id = $data['revenue_item_id'];
        $payment->amount = $data['amount'];
        $payment->penalty_amount = $data['penalty_amount'] ?? 0;
        $payment->status = $data['status'];
        $payment->payment_method = $data['payment_method'] ?? null;
        $payment->reference = $data['reference'] ?? (string) Str::uuid();
        $payment->collected_by = Auth::id();
        $payment->transaction_details = $data['transaction_details'] ?? null;

        // Paid At is automatic
        $payment->paid_at = $payment->status === 'paid' ? now() : null;

        $payment->save();

        return redirect()
            ->route('collector.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $this->ensureCollectorOwnsPayment($payment);

        $payment->load(['revenueItem', 'payer', 'collector']);

        return view('collector.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $this->ensureCollectorOwnsPayment($payment);

        $payers = User::query()
            ->whereIn('role', ['user', 'citizen'])
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $items = RevenueItem::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('collector.payments.edit', compact('payment', 'payers', 'items'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->ensureCollectorOwnsPayment($payment);
        $this->normalizeNullableInputs($request);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'revenue_item_id' => ['required', 'exists:revenue_items,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,paid,failed,reversed'],
            'reference' => ['nullable', 'string', 'max:255', 'unique:payments,reference,' . $payment->id],
            'transaction_details' => ['nullable', 'array'],
        ]);

        $payer = User::query()
            ->where('id', $data['user_id'])
            ->whereIn('role', ['user', 'citizen'])
            ->first();

        if (!$payer) {
            abort(403, 'Only user or citizen accounts can be billed.');
        }

        $payment->user_id = $data['user_id'];
        $payment->revenue_item_id = $data['revenue_item_id'];
        $payment->amount = $data['amount'];
        $payment->penalty_amount = $data['penalty_amount'] ?? 0;
        $payment->status = $data['status'];
        $payment->payment_method = $data['payment_method'] ?? null;
        $payment->reference = $data['reference'] ?? $payment->reference;
        $payment->transaction_details = $data['transaction_details'] ?? $payment->transaction_details;

        // Never let collector change collected_by
        $payment->collected_by = Auth::id();

        // Paid At automatic rules
        if ($payment->status === 'paid') {
            $payment->paid_at = $payment->paid_at ?? now(); // keep old if already set, else set now
        } else {
            $payment->paid_at = null;
        }

        $payment->save();

        return redirect()
            ->route('collector.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function exportPdf()
    {
        $payments = Payment::query()
            ->where('collected_by', Auth::id())
            ->with(['payer', 'revenueItem', 'collector'])
            ->latest()
            ->get();

        // Make sure this Blade exists: resources/views/collector/reports/payments_pdf.blade.php
        $pdf = Pdf::loadView('collector.reports.payments_pdf', compact('payments'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('collector_payments_' . now()->format('Ymd_His') . '.pdf');
    }

public function exportExcel()
{
    return Excel::download(
        new PaymentsExport(null, Auth::id()),
        'collector_payments_' . now()->format('Ymd_His') . '.xlsx'
    );
}

    private function ensureCollectorOwnsPayment(Payment $payment): void
    {
        if ((int) $payment->collected_by !== (int) Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
    }

    private function normalizeNullableInputs(Request $request): void
    {
        foreach (['penalty_amount', 'payment_method', 'reference'] as $field) {
            if ($request->has($field) && $request->input($field) === '') {
                $request->merge([$field => null]);
            }
        }
    }
}
