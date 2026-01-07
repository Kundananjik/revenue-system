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
                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\RevenueCategory::count() }}</p>
            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Categories</a>
        </div>

        <!-- Revenue Items -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Revenue Items</h2>
                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\RevenueItem::count() }}</p>
            <a href="{{ route('admin.items.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Items</a>
        </div>

        <!-- Payments -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Payments</h2>
                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\Payment::count() }}</p>
            <a href="{{ route('admin.payments.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Payments</a>
        </div>

        <!-- Penalties -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Penalties</h2>
                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\Penalty::count() }}</p>
            <a href="{{ route('admin.penalties.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Penalties</a>
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
                @forelse(\App\Models\RevenueItem::with('category')->latest()->take(5)->get() as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $item->id }}</td>
                        <td class="px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-2 font-medium">{{ $item->name }}</td>
                        <td class="px-4 py-2">ZK {{ number_format($item->amount, 2) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $item->payment_frequency }}</td>
                        <td class="px-4 py-2">
                            @if($item->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="font-medium">No revenue items yet</p>
                                <p class="text-sm mt-1">Create your first revenue item to get started</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection