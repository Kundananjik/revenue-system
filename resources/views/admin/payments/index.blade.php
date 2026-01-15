@extends('admin.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Payments</h1>

        <div class="flex flex-wrap items-center gap-2">
            {{-- Export Buttons --}}
            <a href="{{ route('admin.reports.payments.pdf') }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Export PDF
            </a>

            <a href="{{ route('admin.reports.payments.excel') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>

            {{-- Add Payment --}}
            <a href="{{ route('admin.payments.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Payment
            </a>
        </div>
    </div>

    {{-- Alert Section --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Table Section --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Revenue Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Method</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penalty</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Collector</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $payment->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold text-xs">
                                    {{ strtoupper(substr($payment->payer->name ?? 'N', 0, 1)) }}
                                </div>
                                {{ $payment->payer->name ?? '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-semibold">ZMW {{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center gap-1 bg-gray-100 px-2.5 py-1 rounded-md text-xs font-medium text-gray-700">
                                @if(strtolower($payment->payment_method ?? '') === 'cash')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                @endif
                                {{ ucfirst($payment->payment_method ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($payment->penalty_amount > 0)
                                <span class="text-red-600 font-semibold">ZMW {{ number_format($payment->penalty_amount, 2) }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusConfig = match(strtolower($payment->status)) {
                                    'paid', 'completed', 'success' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                                    'failed', 'cancelled' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
                                    default => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z'],
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold leading-5 rounded-full {{ $statusConfig['class'] }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="{{ $statusConfig['icon'] }}"/>
                                </svg>
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->collector->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                            @if($payment->paid_at)
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-700">{{ $payment->paid_at->format('M d, Y') }}</span>
                                    <span class="text-gray-400">{{ $payment->paid_at->format('H:i') }}</span>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.payments.edit', $payment->id) }}" 
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 transition font-medium text-sm"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" 
                                      class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 transition font-medium text-sm"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-16 h-16 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-lg font-medium mb-1">No payments found</p>
                                <p class="text-sm text-gray-400 mb-4">Start recording payments to track revenue</p>
                                <a href="{{ route('admin.payments.create') }}" 
                                   class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Payment
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@if($payments->hasPages())
    <div class="mt-6">
        {{ $payments->onEachSide(1)->links() }}
    </div>
@endif

@if($payments->isNotEmpty())
    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm text-gray-600">
        <div>
            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} payment(s)
        </div>

        <div class="font-semibold">
            Total: <span class="text-blue-600">ZMW {{ number_format($totalAmountAll ?? 0, 2) }}</span>
            @if(($totalPenaltyAll ?? 0) > 0)
                <span class="text-gray-400 mx-2">|</span>
                Penalties: <span class="text-red-600">ZMW {{ number_format($totalPenaltyAll ?? 0, 2) }}</span>
            @endif
        </div>
    </div>
@endif
</div>
@endsection