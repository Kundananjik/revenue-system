@extends('collector.layouts.app')

@section('title', 'Edit Penalty')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Penalty</h1>

    <form action="{{ route('collector.payment.update', $penalty->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <div>
                <label for="amount" class="block mb-1 font-medium">Amount</label>
                <input type="number" name="amount" id="amount" step="0.01" value="{{ $penalty->amount }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
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
                    <option value="0" {{ !$penalty->is_paid ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $penalty->is_paid ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Update Penalty</button>
            <a href="{{ route('collector.dashboard') }}" class="ml-4 text-gray-500 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
