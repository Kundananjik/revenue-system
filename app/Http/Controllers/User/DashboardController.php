<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Penalty;
use App\Models\RevenueItem;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
$userId = Auth::id();

// Total payments made by the logged-in user
$totalPayments = Payment::where('user_id', $userId)->sum('amount');

// Total penalties for the logged-in user
$totalPenalties = Penalty::whereHas('payment', function($q) use ($userId) {
    $q->where('user_id', $userId);
})->sum('amount');

// Count of all revenue items
$revenueItemsCount = RevenueItem::count();

// User account status
$status = Auth::user()->status ?? 'Active';

return view('user.dashboard', [
    'totalPayments' => $totalPayments,
    'totalPenalties' => $totalPenalties,
    'revenueItemsCount' => $revenueItemsCount,
    'status' => $status,
]);
    }
}   