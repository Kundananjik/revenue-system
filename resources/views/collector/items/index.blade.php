@extends('collector.layouts.app')

@section('title', 'Revenue Items')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Revenue Items</h1>

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

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Frequency</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penalty Rate</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 font-mono">{{ $item->code ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $item->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <span class="px-2 py-1 bg-gray-100 rounded text-xs font-medium">{{ ucfirst($item->calculation_type) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-semibold">ZMW {{ number_format($item->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $item->payment_frequency) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($item->penalty_rate * 100, 2) }}%</td>
                        <td class="px-4 py-3">
                            @if($item->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('collector.payment.store') }}?item_id={{ $item->id }}" 
                               class="inline-flex items-center gap-1 text-white bg-blue-500 hover:bg-blue-600 px-3 py-1.5 rounded text-sm font-medium">
                                Record Payment
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center text-gray-500">
                            No revenue items found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($items->isNotEmpty())
        <div class="mt-4 text-sm text-gray-600">
            Showing {{ $items->count() }} item(s)
        </div>
    @endif

</div>
@endsection
