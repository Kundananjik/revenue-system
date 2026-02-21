@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-8 text-gray-800">Admin Dashboard</h1>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Revenue Categories -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Categories</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\RevenueCategory::count() }}</p>
            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Categories</a>
        </div>

        <!-- Revenue Items -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Revenue Items</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\RevenueItem::count() }}</p>
            <a href="{{ route('admin.items.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Items</a>
        </div>

        <!-- Payments -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Payments</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\Payment::count() }}</p>
            <a href="{{ route('admin.payments.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Payments</a>
        </div>

        <!-- Penalties -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Penalties</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ \App\Models\Penalty::count() }}</p>
            <a href="{{ route('admin.penalties.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">View Penalties</a>
        </div>

    </div>

    <!-- Recent Revenue Items Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Recent Revenue Items</h2>
        <x-ui.table>
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
                        <td class="px-4 py-2">ZMW {{ number_format($item->amount, 2) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $item->payment_frequency }}</td>
                        <td class="px-4 py-2">
                            @if($item->is_active)
                                <x-ui.badge type="success">Active</x-ui.badge>
                            @else
                                <x-ui.badge type="danger">Inactive</x-ui.badge>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center">
                            <x-ui.empty-state title="No revenue items yet" message="Create your first revenue item to get started" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table>

</div>
@endsection





