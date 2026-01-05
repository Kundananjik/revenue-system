<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\RevenueItem;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = Payment::with(['payer', 'revenueItem', 'collector'])->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $users = User::all();
        $items = RevenueItem::where('is_active', true)->get();
        return view('admin.payments.create', compact('users', 'items'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'revenue_item_id' => 'required|exists:revenue_items,id',
            'amount' => 'required|numeric|min:0',
            'penalty_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,failed,reversed',
            'payment_method' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255|unique:payments,reference',
            'collected_by' => 'nullable|exists:users,id',
            'paid_at' => 'nullable|date',
        ]);

        Payment::create($validated);

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $users = User::all();
        $items = RevenueItem::where('is_active', true)->get();
        return view('admin.payments.edit', compact('payment', 'users', 'items'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'revenue_item_id' => 'required|exists:revenue_items,id',
            'amount' => 'required|numeric|min:0',
            'penalty_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,failed,reversed',
            'payment_method' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255|unique:payments,reference,' . $payment->id,
            'collected_by' => 'nullable|exists:users,id',
            'paid_at' => 'nullable|date',
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Payment deleted successfully.');
    }
}
