@extends('admin.layouts.app')

@section('title', 'Revenue Items')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Revenue Items</h1>
        <a href="{{ route('admin.items.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
           + Add New Item
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
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Frequency</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penalty</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Active</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $item->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->code ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $item->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ ucfirst($item->calculation_type) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($item->amount, 2) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ ucfirst($item->payment_frequency) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format($item->penalty_rate, 4) }}</td>
                        <td class="px-4 py-3">
                            @if($item->is_active)
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
                            <a href="{{ route('admin.items.edit', $item->id) }}" 
                               class="text-blue-500 hover:underline hover:text-blue-700 transition">Edit</a>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline hover:text-red-700 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-gray-500 font-medium">
                            No revenue items found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
