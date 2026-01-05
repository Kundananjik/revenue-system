@extends('admin.layouts.app')

@section('title', 'Edit Penalty')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Penalty</h1>

    <form action="{{ route('admin.penalties.update', $penalty->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="revenue_item_id" class="block mb-1 font-medium">Revenue Item</label>
                <select name="revenue_item_id" id="revenue_item_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    @foreach($items as $item)
                        <option value="{{ $item->id }}" {{ $penalty->revenue_item_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="payment_id" class="block mb-1 font-medium">Payment (Optional)</label>
                <select name="payment_id" id="payment_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- None --</option>
                    @foreach($payments as $payment)
                        <option value="{{ $payment->id }}" {{ $penalty->payment_id == $payment->id ? 'selected' : '' }}>
                            {{ $payment->reference }} - {{ $payment->payer->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="amount" class="block mb-1 font-medium">Amount</label>
                <input type="number" name="amount" id="amount" step="0.01" value="{{ $penalty->amount }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div>
                <label for="rate" class="block mb-1 font-medium">Rate (%)</label>
                <input type="number" name="rate" id="rate" step="0.0001" value="{{ $penalty->rate }}" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="sm:col-span-2">
                <label for="reason" class="block mb-1 font-medium">Reason</label>
                <input type="text" name="reason" id="reason" value="{{ $penalty->reason }}" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label for="applied_at" class="block mb-1 font-medium">Applied At</label>
                <input type="date" name="applied_at" id="applied_at" value="{{ $penalty->applied_at->format('Y-m-d') }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div>
                <label for="is_paid" class="block mb-1 font-medium">Paid?</label>
                <select name="is_paid" id="is_paid" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="1" {{ $penalty->is_paid ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$penalty->is_paid ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Update Penalty</button>
            <a href="{{ route('admin.penalties.index') }}" class="ml-4 text-gray-500 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
