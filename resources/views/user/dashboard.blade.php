@extends('layouts.user.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    use App\Models\Payment;
    use App\Models\RevenueItem;
    use Illuminate\Support\Facades\Auth;

    $userId = Auth::id();

    // Total payments made by the user
    $totalPayments = Payment::where('user_id', $userId)
                            ->where('status', 'paid')
                            ->sum('amount');

    // Total penalties for the user
    $totalPenalties = Payment::where('user_id', $userId)
                             ->where('status', 'paid')
                             ->sum('penalty_amount');

    // Total revenue items
    $revenueItemsCount = RevenueItem::count();

    // Account status
    $status = Auth::user()->status ?? 'Active';
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

    <!-- Total Payments -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Payments</p>
            <div class="p-2 bg-blue-50 rounded-lg">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1
                        M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">
            ZMW {{ number_format($totalPayments, 2) }}
        </h2>
    </div>

    <!-- My Penalties -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">My Penalties</p>
            <div class="p-2 bg-red-50 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856
                        c1.54 0 2.502-1.667 1.732-3L13.732 4
                        c-.77-1.333-2.694-1.333-3.464 0L3.34 16
                        c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">
            ZMW {{ number_format($totalPenalties, 2) }}
        </h2>
    </div>

    <!-- Revenue Items -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Revenue Items</p>
            <div class="p-2 bg-green-50 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10
                        a2 2 0 002-2V7a2 2 0 00-2-2h-2
                        M9 5a2 2 0 002 2h2a2 2 0 002-2
                        M9 5a2 2 0 012-2h2a2 2 0 012 2
                        m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">
            {{ $revenueItemsCount }}
        </h2>
    </div>

    <!-- Account Status -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Account Status</p>
            <div class="p-2 bg-indigo-50 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                </svg>
            </div>
        </div>
        <div class="flex items-center">
            <span class="flex h-3 w-3 rounded-full bg-green-500 mr-2"></span>
            <h2 class="text-xl font-bold text-gray-900">{{ $status }}</h2>
        </div>
    </div>

</div>

<!-- MOBILE FRIENDLY: STACKED CARDS -->
<div class="md:hidden mt-6 space-y-4">
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Payments</p>
        <h2 class="text-xl font-bold text-gray-900">ZMW {{ number_format($totalPayments, 2) }}</h2>
    </div>
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">My Penalties</p>
        <h2 class="text-xl font-bold text-gray-900">ZMW {{ number_format($totalPenalties, 2) }}</h2>
    </div>
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Revenue Items</p>
        <h2 class="text-xl font-bold text-gray-900">{{ $revenueItemsCount }}</h2>
    </div>
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Account Status</p>
        <div class="flex items-center gap-2">
            <span class="flex h-3 w-3 rounded-full bg-green-500"></span>
            <h2 class="text-xl font-bold text-gray-900">{{ $status }}</h2>
        </div>
    </div>
</div>
@endsection
