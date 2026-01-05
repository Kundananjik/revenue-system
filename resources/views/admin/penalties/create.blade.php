@extends('admin.layouts.app')

@section('title', 'Create Penalty')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Create Penalty</h1>

    <form action="{{ route('admin.penalties.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="revenue_item_id" class="block mb-1 font-medium">Revenue Item</label>
                <select name="revenue_item_id" id="revenue_item_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('revenue_item_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="payment_id" class="block mb-1 font-medium">Payment (Optional)</label>
                <select name="payment_id" id="payment_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- None --</option>
                    @foreach($payments as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->reference }} - {{ $payment->payer->name ?? '-' }}</option>
                    @endforeach
                </select>
                @error('payment_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="amount" class="block mb-1 font-medium">Amount</label>
                <input type="number" name="amount" id="amount" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('amount')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="rate" class="block mb-1 font-medium">Rate (%)</label>
                <input type="number" name="rate" id="rate" step="0.0001" class="w-full border border-gray-300 rounded px-3 py-2">
                @error('rate')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="reason" class="block mb-1 font-medium">Reason</label>
                <input type="text" name="reason" id="reason" class="w-full border border-gray-300 rounded px-3 py-2">
                @error('reason')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="applied_at" class="block mb-1 font-medium">Applied At</label>
                <input type="date" name="applied_at" id="applied_at" class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('applied_at')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="is_paid" class="block mb-1 font-medium">Paid?</label>
                <select name="is_paid" id="is_paid" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @error('is_paid')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Save Penalty</button>
            <a href="{{ route('admin.penalties.index') }}" class="ml-4 text-gray-500 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
