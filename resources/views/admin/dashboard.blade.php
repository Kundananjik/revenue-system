@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <h1 class="text-3xl font-bold mb-8 text-gray-800">Admin Dashboard</h1>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Revenue Categories -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Categories</h2>
                <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\RevenueCategory::count() }}</p>
            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Categories</a>
        </div>

        <!-- Revenue Items -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Revenue Items</h2>
                <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\RevenueItem::count() }}</p>
            <a href="{{ route('admin.items.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Items</a>
        </div>

        <!-- Payments -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Payments</h2>
                <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\Payment::count() }}</p>
            <a href="#" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Payments</a>
        </div>

        <!-- Penalties -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Penalties</h2>
                <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\Penalty::count() }}</p>
            <a href="#" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Penalties</a>
        </div>

    </div>

    <!-- Recent Revenue Items Table -->
    <div class="bg-white rounded-lg shadow-lg p-6 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Recent Revenue Items</h2>
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">ID</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Category</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Name</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Amount</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Frequency</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Active</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach(\App\Models\RevenueItem::with('category')->latest()->take(5)->get() as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $item->id }}</td>
                        <td class="px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-2 font-medium">{{ $item->name }}</td>
                        <td class="px-4 py-2">${{ number_format($item->amount, 2) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $item->payment_frequency }}</td>
                        <td class="px-4 py-2">
                            @if($item->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
