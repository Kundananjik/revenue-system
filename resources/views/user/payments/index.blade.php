@extends('layouts.app')

@section('title','My Payments')
@section('page-title','My Payments')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header Section --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Payments</h1>
            <p class="text-sm text-gray-500 mt-1">Your personal payment history and exports</p>
        </div>

        {{-- Export Buttons --}}
        <div class="flex flex-wrap gap-2">
            <x-ui.button href="{{ route('user.payments.export.pdf') }}" variant="danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v10m0 0l3-3m-3 3L9 10m9 11H6a2 2 0 01-2-2v-4a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </x-ui.button>

            <x-ui.button href="{{ route('user.payments.export.excel') }}" variant="success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-8 4h8a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Export Excel
            </x-ui.button>
        </div>
    </div>

    {{-- Alert Section --}}
    @if(session('success'))
    <x-ui.alert type="success" dismissable class="mb-6">
        <svg class="w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </x-ui.alert>
@endif

    {{-- Summary Cards --}}
    @php
        $totalAll = $payments->total() ? (float) (clone $payments)->getCollection()->sum('amount') : 0; // current page sum
        $pageAmount = (float) $payments->sum('amount');
        $pagePenalty = (float) $payments->sum('penalty_amount');
        $paidCount = $payments->getCollection()->where('status', 'paid')->count();
        $pendingCount = $payments->getCollection()->where('status', 'pending')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">On this page</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $payments->count() }}</p>
            <p class="text-sm text-gray-500 mt-1">record(s)</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">Page total</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">ZMW {{ number_format($pageAmount, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">amount</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">Page penalties</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">ZMW {{ number_format($pagePenalty, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">penalty sum</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase">Statuses</p>
            <div class="mt-2 flex items-center gap-2 flex-wrap">
                <x-ui.badge type="success">Paid: {{ $paidCount }}
                </x-ui.badge>
                <x-ui.badge type="warning">Pending: {{ $pendingCount }}
                </x-ui.badge>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <x-ui.table>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Revenue Item</th>
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
                                {{ ucfirst($payment->payment_method ?? 'N/A') }}
                            </span>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $badgeType = match($statusConfig['label']) {
                                    'Paid' => 'success',
                                    'Pending' => 'warning',
                                    'Failed' => 'danger',
                                    default => 'neutral',
                                };
                            @endphp
                            <x-ui.badge :type="$badgeType">{{ $statusConfig['label'] }}</x-ui.badge>
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                            {{ $payment->collector->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                            {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                            {{ $payment->created_at?->format('d M Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center">
                            <x-ui.empty-state title="No payments found" message="You haven't made any payments yet." />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table>

    {{-- Pagination --}}
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









