@extends('admin.layouts.app')

@section('title', 'Penalties')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Penalties</h1>
        <a href="{{ route('admin.penalties.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
            + Add New Penalty
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
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Revenue Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment Ref</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rate</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reason</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Applied At</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paid</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($penalties as $penalty)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $penalty->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $penalty->revenueItem->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $penalty->payment->reference ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($penalty->amount, 2) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($penalty->rate ?? 0, 4) }}%</td>
                        <td class="px-4 py-3 text-gray-600">{{Str::limit($penalty->reason ?? '-', 30) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $penalty->applied_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if($penalty->is_paid)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                    Yes
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">
                                    No
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2 flex items-center">
                            <a href="{{ route('admin.penalties.edit', $penalty->id) }}" 
                               class="text-blue-500 hover:underline hover:text-blue-700 transition">Edit</a>
                            
                            <form action="{{ route('admin.penalties.destroy', $penalty->id) }}" method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this penalty?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline hover:text-red-700 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500 font-medium">
                            No penalties found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection