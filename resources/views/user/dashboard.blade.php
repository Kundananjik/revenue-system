@extends('layouts.app')

@section('title', 'User Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    use App\Models\Payment;
    use App\Models\RevenueItem;
    use Illuminate\Support\Facades\Auth;

    $userId = Auth::id();

    $totalPayments = Payment::where('user_id', $userId)
        ->where('status', 'paid')
        ->sum('amount');

    $totalPenalties = Payment::where('user_id', $userId)
        ->where('status', 'paid')
        ->sum('penalty_amount');

    $revenueItemsCount = RevenueItem::count();

    $status = Auth::user()->status ?? 'Active';

    $recentPayments = Payment::with('revenueItem')
        ->where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();
@endphp

<div class="max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-8 text-gray-800">User Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Total Payments</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">ZMW {{ number_format($totalPayments, 2) }}</p>
            <a href="{{ route('user.payments.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Payments
            </a>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">My Penalties</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">ZMW {{ number_format($totalPenalties, 2) }}</p>
            <a href="{{ route('user.penalties.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Penalties
            </a>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Revenue Items</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ $revenueItemsCount }}</p>
            <a href="{{ route('user.items.index') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                View Items
            </a>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-sm transform hover:scale-105 transition">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Account Status</h2>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ $status }}</p>
            <a href="{{ route('user.profile.edit') }}" class="mt-4 inline-block text-sm font-medium underline hover:text-gray-100">
                Manage Profile
            </a>
        </div>

    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Recent Payments</h2>

        <x-ui.table>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">ID</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Revenue Item</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Amount</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Penalty</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Status</th>
                    <th class="px-4 py-2 text-left text-gray-600 font-medium uppercase text-xs">Date</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentPayments as $p)
                    @php
                        $statusPill = match($p->status) {
                            'paid' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'reversed' => 'bg-gray-100 text-gray-800',
                            default => 'bg-gray-100 text-gray-800',
                        };

                        $date = $p->paid_at ?? $p->created_at;
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $p->id }}</td>
                        <td class="px-4 py-2 font-medium">{{ optional($p->revenueItem)->name ?? '-' }}</td>
                        <td class="px-4 py-2">ZMW {{ number_format($p->amount ?? 0, 2) }}</td>
                        <td class="px-4 py-2">ZMW {{ number_format($p->penalty_amount ?? 0, 2) }}</td>
                        <td class="px-4 py-2">
                            @php
                                $badgeType = match($p->status) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'failed' => 'danger',
                                    default => 'neutral',
                                };
                            @endphp
                            <x-ui.badge :type="$badgeType">{{ ucfirst($p->status) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-2">
                            {{ $date ? $date->format('d M Y') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center">
                            <x-ui.empty-state title="No payments yet" message="Once you make payments, they will appear here" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-ui.table>

</div>
@endsection





