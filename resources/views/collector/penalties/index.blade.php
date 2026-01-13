@extends('collector.layouts.app')

@section('title', 'Penalties')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Penalties</h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Revenue Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment Ref</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rate</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reason</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Applied Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($penalties as $penalty)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $penalty->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $penalty->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 font-mono">{{ $penalty->payment->reference ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-red-600">ZMW {{ number_format($penalty->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm">{{ number_format(($penalty->rate ?? 0) * 100, 2) }}%</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $penalty->reason ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $penalty->applied_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            @if($penalty->is_paid)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">
                                    Unpaid
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                            No penalties found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($penalties->isNotEmpty())
        <div class="mt-4 text-sm text-gray-600">
            Showing {{ $penalties->count() }} penalty{{ $penalties->count() === 1 ? '' : 'ies' }} | Total: ZMW {{ number_format($penalties->sum('amount'), 2) }}
        </div>
    @endif

</div>
@endsection
