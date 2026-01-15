@extends('collector.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Payments</h1>

        <a href="{{ route('collector.payments.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
            Add Payment
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
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
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paid At</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    @php
                        $statusClasses = match(strtolower($payment->status)) {
                            'paid' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'reversed' => 'bg-gray-100 text-gray-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $payment->payer->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($payment->penalty_amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->payment_method ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full {{ $statusClasses }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500 font-medium">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>

</div>
@endsection
