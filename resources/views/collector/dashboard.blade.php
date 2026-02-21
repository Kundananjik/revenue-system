@extends('layouts.app')

@section('title', 'Collector Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Collector Dashboard</h1>

        <a href="{{ route('collector.payments.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
            View All Payments
        </a>
    </div>

    {{-- Stat Cards (Admin style gradients) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Payments Collected --}}
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Payments Collected</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ $paymentsCount }}</p>
            <a href="{{ route('collector.payments.index') }}"
               class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Payments
            </a>
        </div>

        {{-- Total Amount Collected --}}
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Total Collected</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">ZMW {{ number_format($totalAmountCollected, 2) }}</p>
            <a href="{{ route('collector.payments.index') }}"
               class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Breakdown
            </a>
        </div>

        {{-- Penalties Issued --}}
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Penalties Issued</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ $penaltiesCount }}</p>
            <a href="{{ route('collector.payments.index') }}"
               class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Payments
            </a>
        </div>

        {{-- Active Revenue Items --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Active Items</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                          M9 5a2 2 0 002 2h2a2 2 0 002-2
                          M9 5a2 2 0 012-2h2a2 2 0 012 2
                          m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ $activeRevenueItemsCount }}</p>
            <a href="{{ route('collector.revenue.items') }}"
               class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Items
            </a>
        </div>

    </div>

    {{-- Recent Payments Table (Admin style container) --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Recent Payments</h2>

            <a href="{{ route('collector.payments.index') }}"
               class="text-sm font-semibold text-blue-600 hover:underline">
                View all
            </a>
        </div>

        <x-ui.table>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Payer</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Revenue Item</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Amount</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Status</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Paid At</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentPayments as $payment)
                    @php
                        $badge = match(strtolower((string) $payment->status)) {
                            'paid' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'reversed' => 'bg-gray-100 text-gray-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-medium">{{ $payment->payer->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $payment->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-2 font-semibold">ZMW {{ number_format((float)$payment->amount, 2) }}</td>
                        <td class="px-4 py-2">
                            @php
                                $badgeType = match(strtolower((string) $payment->status)) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'failed' => 'danger',
                                    default => 'neutral',
                                };
                            @endphp
                            <x-ui.badge :type="$badgeType">{{ ucfirst((string) $payment->status) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center">
                            <x-ui.empty-state title="No payments recorded yet" message="Start collecting payments to see them here" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table>

</div>
@endsection





