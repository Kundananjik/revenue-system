@extends('collector.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Payments</h1>
    </div>

    {{-- Table Section --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Revenue Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Method</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penalty</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paid Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $payment->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-semibold">ZMW {{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm">{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                        <td class="px-4 py-3 text-sm text-red-600 font-semibold">
                            {{ $payment->penalty_amount > 0 ? 'ZMW '.number_format($payment->penalty_amount, 2) : '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ $payment->status === 'paid' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                            {{ $payment->paid_at?->format('M d, Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                            No payments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->isNotEmpty())
        <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
            <div>Showing {{ $payments->count() }} payment(s)</div>
            <div class="font-semibold">
                Total: <span class="text-blue-600">ZMW {{ number_format($payments->sum('amount'), 2) }}</span>
            </div>
        </div>
    @endif

</div>
@endsection
