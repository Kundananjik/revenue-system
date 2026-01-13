@extends('collector.layouts.app')

@section('title', 'Collector Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Page Title -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Collector Dashboard</h1>

        <a href="{{ route('collector.payments.index') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
            View All Payments
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- Payments Count -->
        <a href="{{ route('collector.payments.index') }}"
           class="block bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Payments Collected</p>
                <div class="p-2 bg-yellow-50 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1
                            M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $paymentsCount }}</h2>
        </a>

        <!-- Total Amount -->
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Amount Collected</p>
                <div class="p-2 bg-indigo-50 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">
                ZMW {{ number_format($totalAmountCollected, 2) }}
            </h2>
        </div>

        <!-- Penalties -->
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Penalties Issued</p>
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
            <h2 class="text-2xl font-bold text-gray-900">{{ $penaltiesCount }}</h2>
        </div>

        <!-- Revenue Items -->
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-6 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Revenue Items</p>
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
            <h2 class="text-2xl font-bold text-gray-900">{{ $activeRevenueItemsCount }}</h2>
        </div>

    </div>

    <!-- MOBILE FRIENDLY: STACKED CARDS -->
    <div class="md:hidden mt-6 space-y-4">
        <a href="{{ route('collector.payments.index') }}" class="block bg-white shadow-sm border border-gray-100 rounded-xl p-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Payments Collected</p>
            <h2 class="text-xl font-bold text-gray-900">{{ $paymentsCount }}</h2>
        </a>
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Amount Collected</p>
            <h2 class="text-xl font-bold text-gray-900">ZMW {{ number_format($totalAmountCollected, 2) }}</h2>
        </div>
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Penalties Issued</p>
            <h2 class="text-xl font-bold text-gray-900">{{ $penaltiesCount }}</h2>
        </div>
        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Revenue Items</p>
            <h2 class="text-xl font-bold text-gray-900">{{ $activeRevenueItemsCount }}</h2>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-10">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Recent Payments</h2>

            <a href="{{ route('collector.payments.index') }}"
               class="text-sm font-semibold text-indigo-600 hover:underline">
                View all
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Payer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Revenue Item</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Paid At</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                {{ $payment->payer->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $payment->revenueItem->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 font-semibold">
                                ZMW {{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ optional($payment->paid_at)->format('d M Y') ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                No payments recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection