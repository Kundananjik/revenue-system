@extends('layouts.app')

@section('title', 'Add Payment')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Header --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add Payment</h1>
                <p class="text-sm text-gray-500 mt-1">Record a new payment collection</p>
            </div>

            <a href="{{ route('collector.payments.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
            <x-ui.alert type="danger" class="mb-5">
                <div>
                    <p class="font-semibold mb-2">Please fix the following:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </x-ui.alert>
        @endif

        <form action="{{ route('collector.payments.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Payer --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Payer</label>
                <select name="user_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Select User</option>
                    @foreach(($payers ?? []) as $payer)
                        <option value="{{ $payer->id }}" {{ old('user_id') == $payer->id ? 'selected' : '' }}>
                            {{ $payer->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Revenue Item --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Revenue Item</label>
                <select name="revenue_item_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Select Item</option>
                    @foreach(($items ?? []) as $item)
                        <option value="{{ $item->id }}" {{ old('revenue_item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                @error('revenue_item_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Amounts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Amount</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                           placeholder="0.00">
                    @error('amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Penalty Amount</label>
                    <input type="number" step="0.01" name="penalty_amount" value="{{ old('penalty_amount', 0) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                           placeholder="0.00">
                    @error('penalty_amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Method + Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Payment Method</label>
                    <input type="text" name="payment_method" value="{{ old('payment_method') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                           placeholder="Cash, Mobile Money, Bank">
                    @error('payment_method') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    @php $status = old('status', 'paid'); @endphp
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="reversed" {{ $status === 'reversed' ? 'selected' : '' }}>Reversed</option>
                    </select>
                    @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Reference --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Reference</label>
                <input type="text" name="reference" value="{{ old('reference') }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                       placeholder="Optional">
                @error('reference') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Paid At (Auto) --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Paid At is automatic</p>
                        <p class="text-sm text-gray-600">
                            When you save with status <span class="font-semibold">Paid</span>, the system sets the payment time automatically.
                            If status is not paid, <span class="font-semibold">Paid At</span> remains empty.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-2 flex items-center gap-3">
                <x-ui.button type="submit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Payment
                </x-ui.button>

                <a href="{{ route('collector.payments.index') }}"
                   class="text-sm font-semibold text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection





