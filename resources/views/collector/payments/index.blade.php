@extends('collector.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Payments</h1>
            <p class="text-sm text-gray-500 mt-1">Track payments you collected and their status</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            {{-- Export PDF --}}
            <a href="{{ route('collector.payments.export.pdf') }}"
               class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v10m0 0l3-3m-3 3L9 10m9 11H6a2 2 0 01-2-2v-4a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>

            {{-- Export Excel --}}
            <a href="{{ route('collector.payments.export.excel') }}"
               class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-8 4h8a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Export Excel
            </a>

            {{-- Add Payment --}}
            <a href="{{ route('collector.payments.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Payment
            </a>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm flex items-start justify-between gap-3">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>

            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900" aria-label="Dismiss">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Summary Cards --}}
    @php
        $pageAmount = (float) $payments->getCollection()->sum('amount');
        $pagePenalty = (float) $payments->getCollection()->sum('penalty_amount');
        $paidCount = $payments->getCollection()->where('status', 'paid')->count();
        $pendingCount = $payments->getCollection()->where('status', 'pending')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">On this page</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $payments->count() }}</p>
            <p class="text-sm text-gray-500 mt-1">payment(s)</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">Page total</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">ZMW {{ number_format($pageAmount, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">amount</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">Page penalties</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">ZMW {{ number_format($pagePenalty, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">penalty sum</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">Statuses</p>
            <div class="mt-2 flex flex-wrap gap-2">
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    Paid: {{ $paidCount }}
                </span>
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Pending: {{ $pendingCount }}
                </span>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penalty</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Method</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Collector</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paid At</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created At</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    @php
                        $statusConfig = match(strtolower((string) $payment->status)) {
                            'paid' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Paid'],
                            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'Pending'],
                            'failed' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Failed'],
                            'reversed' => ['class' => 'bg-gray-200 text-gray-800', 'label' => 'Reversed'],
                            default => ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst((string) $payment->status)],
                        };

                        $payerName = $payment->payer->name ?? '-';
                        $payerInitial = strtoupper(substr($payerName !== '-' ? $payerName : 'N', 0, 1));

                        $method = ucfirst($payment->payment_method ?? 'N/A');
                        $collectorName = $payment->collector->name ?? '-';
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $payment->id }}</td>

                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold text-xs">
                                    {{ $payerInitial }}
                                </div>
                                <span class="whitespace-nowrap">{{ $payerName }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->revenueItem->name ?? '-' }}</td>

                        <td class="px-4 py-3 text-sm text-gray-900 font-semibold whitespace-nowrap">
                            ZMW {{ number_format((float) $payment->amount, 2) }}
                        </td>

                        <td class="px-4 py-3 text-sm whitespace-nowrap">
                            @if((float) $payment->penalty_amount > 0)
                                <span class="text-red-600 font-semibold">
                                    ZMW {{ number_format((float) $payment->penalty_amount, 2) }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 bg-gray-100 px-2.5 py-1 rounded-md text-xs font-medium text-gray-700">
                                {{ $method }}
                            </span>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold leading-5 rounded-full {{ $statusConfig['class'] }}">
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ $collectorName }}</td>

                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                            {{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : '-' }}
                        </td>

                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                            {{ $payment->created_at?->format('M d, Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center text-gray-500 font-medium">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    @if($payments->isNotEmpty())
        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm text-gray-600">
            <div>
                Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} payment(s)
            </div>

            <div class="font-semibold">
                Page Total:
                <span class="text-blue-600">ZMW {{ number_format($pageAmount, 2) }}</span>
            </div>
        </div>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    @endif

</div>
@endsection
