@extends('admin.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Payments</h1>
        <a href="{{ route('admin.payments.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
            + Add Payment
        </a>
    </div>

    {{-- Alert Section --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Section --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penalty</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Collected By</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paid At</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $payment->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $payment->payer->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $payment->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($payment->penalty_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            {{-- Badge styling logic to match the reference 'Active' look --}}
                            @php
                                $statusClasses = match(strtolower($payment->status)) {
                                    'paid', 'completed', 'success' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'failed', 'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full {{ $statusClasses }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $payment->collector->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 text-sm">{{ $payment->paid_at?->format('Y-m-d H:i') ?? '-' }}</td>
                        <td class="px-4 py-3 space-x-2 flex items-center">
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" 
                               class="text-blue-500 hover:underline hover:text-blue-700 transition">Edit</a>
                            
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline hover:text-red-700 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500 font-medium">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection