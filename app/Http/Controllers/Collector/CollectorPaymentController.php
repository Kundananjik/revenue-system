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

class CollectorPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->where('collected_by', Auth::id())
            ->with(['revenueItem', 'payer'])
            ->latest('paid_at')
            ->paginate(10);

        return view('collector.payments.index', compact('payments'));
    }

    public function create()
    {
        // Payers: support BOTH role 'user' and legacy 'citizen'
        $payers = User::query()
            ->whereIn('role', ['user', 'citizen'])
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $items = RevenueItem::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('collector.payments.create', compact('payers', 'items'));
    }

    public function store(Request $request)
    {
        $this->normalizeNullableInputs($request);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'revenue_item_id' => ['required', 'exists:revenue_items,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,paid,failed,reversed'],
            'reference' => ['nullable', 'string', 'max:255', 'unique:payments,reference'],
            'paid_at' => ['nullable', 'date'],
            'transaction_details' => ['nullable', 'array'],
        ]);

        // ensure collector bills only payer roles: user/citizen
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
        $payment->penalty_amount = 0;
        $payment->status = $data['status'];
        $payment->payment_method = $data['payment_method'];
        $payment->reference = $data['reference'] ?? (string) Str::uuid();
        $payment->collected_by = Auth::id();

        // paid_at logic
        if ($payment->status === 'paid') {
            $payment->paid_at = $data['paid_at'] ?? now();
        } else {
            $payment->paid_at = $data['paid_at']; // can be null
        }

        $payment->transaction_details = $data['transaction_details'] ?? null;

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
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,paid,failed,reversed'],
            'reference' => ['nullable', 'string', 'max:255', 'unique:payments,reference,' . $payment->id],
            'paid_at' => ['nullable', 'date'],
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
        $payment->status = $data['status'];
        $payment->payment_method = $data['payment_method'];
        $payment->reference = $data['reference'] ?? $payment->reference;
        $payment->transaction_details = $data['transaction_details'] ?? $payment->transaction_details;

        if ($payment->status === 'paid') {
            $payment->paid_at = $data['paid_at'] ?? ($payment->paid_at ?? now());
        } else {
            $payment->paid_at = $data['paid_at'];
        }

        // never let collector change collected_by
        $payment->collected_by = Auth::id();

        $payment->save();

        return redirect()
            ->route('collector.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function exportPdf()
    {
        $payments = Payment::query()
            ->where('collected_by', Auth::id())
            ->with(['revenueItem', 'payer'])
            ->latest('paid_at')
            ->get();

        $pdf = Pdf::loadView('collector.reports.payments_pdf', compact('payments'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('collector-payments-report.pdf');
    }

    private function ensureCollectorOwnsPayment(Payment $payment): void
    {
        if ((int) $payment->collected_by !== (int) Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
    }

    private function normalizeNullableInputs(Request $request): void
    {
        foreach (['payment_method', 'reference', 'paid_at'] as $field) {
            if ($request->has($field) && $request->input($field) === '') {
                $request->merge([$field => null]);
            }
        }
    }
}
