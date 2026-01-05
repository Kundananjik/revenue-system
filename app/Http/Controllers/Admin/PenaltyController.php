<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalty;
use App\Models\RevenueItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    // List all penalties
    public function index()
    {
        $penalties = Penalty::with(['revenueItem', 'payment.payer'])->latest()->get();
        return view('admin.penalties.index', compact('penalties'));
    }

    // Show create form
    public function create()
    {
        $items = RevenueItem::where('is_active', true)->get();
        $payments = Payment::where('status', 'paid')->latest()->get();
        return view('admin.penalties.create', compact('items', 'payments'));
    }

    // Store new penalty
    public function store(Request $request)
    {
        $validated = $request->validate([
            'revenue_item_id' => 'required|exists:revenue_items,id',
            'payment_id' => 'nullable|exists:payments,id',
            'amount' => 'required|numeric|min:0',
            'rate' => 'nullable|numeric|min:0|max:100',
            'reason' => 'nullable|string|max:255',
            'applied_at' => 'required|date',
            'is_paid' => 'required|boolean',
        ]);

        Penalty::create($validated);

        return redirect()->route('admin.penalties.index')
                         ->with('success', 'Penalty created successfully.');
    }

    // Show edit form
    public function edit(Penalty $penalty)
    {
        $items = RevenueItem::where('is_active', true)->get();
        $payments = Payment::where('status', 'paid')->latest()->get();
        return view('admin.penalties.edit', compact('penalty', 'items', 'payments'));
    }

    // Update penalty
    public function update(Request $request, Penalty $penalty)
    {
        $validated = $request->validate([
            'revenue_item_id' => 'required|exists:revenue_items,id',
            'payment_id' => 'nullable|exists:payments,id',
            'amount' => 'required|numeric|min:0',
            'rate' => 'nullable|numeric|min:0|max:100',
            'reason' => 'nullable|string|max:255',
            'applied_at' => 'required|date',
            'is_paid' => 'required|boolean',
        ]);

        $penalty->update($validated);

        return redirect()->route('admin.penalties.index')
                         ->with('success', 'Penalty updated successfully.');
    }

    // Delete penalty
    public function destroy(Penalty $penalty)
    {
        $penalty->delete();

        return redirect()->route('admin.penalties.index')
                         ->with('success', 'Penalty deleted successfully.');
    }
}
