@extends('layouts.app')

@section('title','My Penalties')
@section('page-title','My Penalties')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Penalties</h1>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <x-ui.alert type="success" dismissable>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </x-ui.alert>
    @endif

    {{-- Table --}}
    <x-ui.table>
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
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $penalty->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $penalty->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 font-mono">
                            {{ $penalty->payment->reference ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-red-600">ZMW {{ number_format($penalty->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm">
                            {{ number_format(($penalty->rate ?? 0) * 100, 2) }}%
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($penalty->reason, 40, '...') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $penalty->applied_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if($penalty->is_paid)
                                <x-ui.badge type="success">Paid</x-ui.badge>
                            @else
                                <x-ui.badge type="danger">Unpaid</x-ui.badge>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                            <x-ui.empty-state title="No penalties found" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
    </x-ui.table>

    {{-- Pagination & Summary --}}
    @if($penalties->isNotEmpty())
        <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
            <div>
                Showing {{ $penalties->count() }} penalty{{ $penalties->count() === 1 ? '' : 'ies' }}
            </div>
            <div class="flex items-center gap-4">
                <div>
                    <span class="font-medium">{{ $penalties->where('is_paid', false)->count() }} unpaid</span>
                </div>
                <div class="font-semibold text-red-600">
                    Total Penalties: ZMW {{ number_format($penalties->sum('amount'), 2) }}
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $penalties->links() }}
        </div>
    @endif

</div>
@endsection





