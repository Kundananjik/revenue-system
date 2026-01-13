@extends('collector.layouts.app')

@section('title', 'Add Payment')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Add Payment</h1>

    <form action="{{ route('collector.payments.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1">Revenue Item</label>
            <select name="revenue_item_id" class="w-full border-gray-300 rounded p-2">
                <option value="">-- Select Item --</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ old('revenue_item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            @error('revenue_item_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="w-full border-gray-300 rounded p-2" required>
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Penalty Amount</label>
            <input type="number" step="0.01" name="penalty_amount" value="{{ old('penalty_amount', 0) }}" class="w-full border-gray-300 rounded p-2">
            @error('penalty_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded p-2">
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Payment Method</label>
            <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="w-full border-gray-300 rounded p-2" required>
            @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Reference</label>
            <input type="text" name="reference" value="{{ old('reference') }}" class="w-full border-gray-300 rounded p-2">
            @error('reference') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Paid At</label>
            <input type="datetime-local" name="paid_at" value="{{ old('paid_at') }}" class="w-full border-gray-300 rounded p-2">
            @error('paid_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <input type="hidden" name="collected_by" value="{{ auth()->id() }}">

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Payment</button>
    </form>
</div>
@endsection
