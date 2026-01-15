<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\RevenueItem;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['payer', 'revenueItem', 'collector'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        // Payers: support BOTH 'user' and legacy 'citizen'
        $users = User::query()
            ->whereIn('role', ['user', 'citizen'])
            ->orderBy('name')
            ->get();

        // Collectors: allow collector, admin, super-admin
        $collectors = User::query()
            ->whereIn('role', ['collector', 'admin', 'super-admin'])
            ->orderBy('name')
            ->get();

        $items = RevenueItem::query()
            ->orderBy('name')
            ->get();

        return view('admin.payments.create', compact('users', 'collectors', 'items'));
    }

    public function store(Request $request)
    {
        $this->normalizeNullableInputs($request);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'revenue_item_id' => ['required', 'exists:revenue_items,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,paid,failed,reversed'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255', 'unique:payments,reference'],
            'collected_by' => ['nullable', 'exists:users,id'],
            'paid_at' => ['nullable', 'date'],
        ]);

        Payment::create($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        $users = User::query()
            ->whereIn('role', ['user', 'citizen'])
            ->orderBy('name')
            ->get();

        $collectors = User::query()
            ->whereIn('role', ['collector', 'admin', 'super-admin'])
            ->orderBy('name')
            ->get();

        $items = RevenueItem::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.payments.edit', compact('payment', 'users', 'collectors', 'items'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->normalizeNullableInputs($request);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'revenue_item_id' => ['required', 'exists:revenue_items,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,paid,failed,reversed'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255', 'unique:payments,reference,' . $payment->id],
            'collected_by' => ['nullable', 'exists:users,id'],
            'paid_at' => ['nullable', 'date'],
        ]);

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    private function normalizeNullableInputs(Request $request): void
    {
        // Convert empty strings from form selects/inputs into null so "nullable|exists" works correctly
        foreach (['penalty_amount', 'payment_method', 'reference', 'collected_by', 'paid_at'] as $field) {
            if ($request->has($field) && $request->input($field) === '') {
                $request->merge([$field => null]);
            }
        }
    }
}
