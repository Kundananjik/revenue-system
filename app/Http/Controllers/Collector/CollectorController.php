<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\RevenueItem;
use App\Models\RevenueCategory;
use App\Models\Penalty;

// Required for Laravel 11 Middleware
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CollectorController extends Controller implements HasMiddleware
{
    /**
     * Define middleware using the Laravel 11 HasMiddleware interface
     */
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:collector'),
        ];
    }

    /**
     * Show dashboard for collector
     */
    public function dashboard()
    {
        $collectorId = Auth::id();

        // Payments collected stats
        $paymentsCount = Payment::where('collected_by', $collectorId)->count();
        $totalAmountCollected = Payment::where('collected_by', $collectorId)->sum('amount');

        // Penalties issued via payments this collector handled
        $penaltiesCount = Penalty::whereHas('payment', function ($q) use ($collectorId) {
            $q->where('collected_by', $collectorId);
        })->count();

        // Active revenue items
        $activeRevenueItemsCount = RevenueItem::where('is_active', 1)->count();

        // Recent payments - Using 'user' relationship to match your User Model
// In CollectorController.php or PaymentController.php
$recentPayments = Payment::with(['payer', 'revenueItem']) // Use 'payer' instead of 'user'
    ->where('collected_by', $collectorId)
    ->latest('paid_at')
    ->take(10)
    ->get();
    
        return view('collector.dashboard', compact(
            'paymentsCount',
            'totalAmountCollected',
            'penaltiesCount',
            'activeRevenueItemsCount',
            'recentPayments'
        ));
    }

    /**
     * Record a new payment
     */
    public function storePayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'revenue_item_id' => 'required|exists:revenue_items,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
            'paid_at' => 'required|date',
        ]);

        Payment::create([
            'user_id' => $request->user_id,
            'revenue_item_id' => $request->revenue_item_id,
            'amount' => $request->amount,
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'reference' => $request->reference,
            'collected_by' => Auth::id(),
            'paid_at' => $request->paid_at,
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    /**
     * Show payment details
     */
    public function showPayment($id)
    {
        // Consistency: Changed 'payer' to 'user'
        $payment = Payment::with(['revenueItem', 'user'])->findOrFail($id);

        if ($payment->collected_by != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('collector.payment_details', compact('payment'));
    }

    /**
     * Update a payment
     */
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->collected_by != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
            'paid_at' => 'required|date',
        ]);

        $payment->update([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'reference' => $request->reference,
            'paid_at' => $request->paid_at,
        ]);

        return redirect()->back()->with('success', 'Payment updated successfully!');
    }

    /**
     * List all active revenue items
     */
    public function revenueItems()
    {
        $items = RevenueItem::where('is_active', 1)->with('category')->get();
        return view('collector.revenue_items', compact('items'));
    }
}