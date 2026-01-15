@extends('collector.layouts.app')

@section('title', 'Add Payment')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Add Payment</h1>
        <a href="{{ route('collector.payments.index') }}" class="text-sm text-blue-600 hover:underline">Back</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded p-3">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('collector.payments.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium mb-1">Payer</label>
            <select name="user_id" class="w-full border-gray-300 rounded p-2">
                <option value="">Select User</option>

                {{-- FIX: controller sends $payers --}}
                @foreach(($payers ?? []) as $payer)
                    <option value="{{ $payer->id }}" {{ old('user_id') == $payer->id ? 'selected' : '' }}>
                        {{ $payer->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Revenue Item</label>
            <select name="revenue_item_id" class="w-full border-gray-300 rounded p-2">
                <option value="">Select Item</option>
                @foreach(($items ?? []) as $item)
                    <option value="{{ $item->id }}" {{ old('revenue_item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            @error('revenue_item_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                       class="w-full border-gray-300 rounded p-2" placeholder="0.00">
                @error('amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Penalty Amount</label>
                <input type="number" step="0.01" name="penalty_amount" value="{{ old('penalty_amount', 0) }}"
                       class="w-full border-gray-300 rounded p-2" placeholder="0.00">
                @error('penalty_amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Payment Method</label>
                <input type="text" name="payment_method" value="{{ old('payment_method') }}"
                       class="w-full border-gray-300 rounded p-2" placeholder="Cash, Mobile Money, Bank">
                @error('payment_method') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded p-2">
                    @php $status = old('status', 'paid'); @endphp
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>pending</option>
                    <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>paid</option>
                    <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>failed</option>
                    <option value="reversed" {{ $status === 'reversed' ? 'selected' : '' }}>reversed</option>
                </select>
                @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Reference</label>
                <input type="text" name="reference" value="{{ old('reference') }}"
                       class="w-full border-gray-300 rounded p-2" placeholder="Optional">
                @error('reference') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Paid At</label>
                <input type="datetime-local" name="paid_at" value="{{ old('paid_at') }}"
                       class="w-full border-gray-300 rounded p-2">
                @error('paid_at') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Payment
            </button>
        </div>
    </form>
</div>
@endsection
