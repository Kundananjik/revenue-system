@extends('layouts.user.app')

@section('title','My Payments')
@section('page-title','My Payments')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Payments</h1>

        {{-- Export Buttons --}}
        <div class="flex gap-2">
            <a href="{{ route('user.payments.export.pdf') }}" 
               class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md text-sm font-semibold transition transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v.01M12 6v.01M12 18v.01M12 12h.01M6 12h.01M18 12h.01M12 6h.01M12 18h.01"/>
                </svg>
                Export PDF
            </a>

            <a href="{{ route('user.payments.export.excel') }}" 
               class="flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md text-sm font-semibold transition transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4z"/>
                </svg>
                Export Excel
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
                                    'paid' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Paid'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'Pending'],
                                    'failed' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Failed'],
                                    default => ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($payment->status)],
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold leading-5 rounded-full {{ $statusConfig['class'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->collector->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $payment->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <p class="text-lg font-medium mb-1">No payments found</p>
                                <p class="text-sm text-gray-400">You haven't made any payments yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination & Total --}}
    @if($payments->isNotEmpty())
        <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
            <div>
                Showing {{ $payments->count() }} payment(s)
            </div>
            @if($payments->sum('amount') > 0)
                <div class="font-semibold">
                    Total: <span class="text-blue-600">ZMW {{ number_format($payments->sum('amount'), 2) }}</span>
                </div>
            @endif
        </div>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    @endif

</div>
@endsection
