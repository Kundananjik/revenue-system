@extends('admin.layouts.app')

@section('title', 'Edit Revenue Item')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Revenue Item</h1>

    <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Category -->
            <div>
                <label class="block font-semibold mb-1">Category</label>
                <select name="category_id" class="w-full border p-2 rounded">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @if($item->category_id==$cat->id) selected @endif>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Name -->
            <div>
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" value="{{ $item->name }}" class="w-full border p-2 rounded">
            </div>

            <!-- Code -->
            <div>
                <label class="block font-semibold mb-1">Code</label>
                <input type="text" name="code" value="{{ $item->code }}" class="w-full border p-2 rounded">
            </div>

            <!-- Amount -->
            <div>
                <label class="block font-semibold mb-1">Amount</label>
                <input type="number" name="amount" step="0.01" value="{{ $item->amount }}" class="w-full border p-2 rounded">
            </div>

            <!-- Calculation Type -->
            <div>
                <label class="block font-semibold mb-1">Calculation Type</label>
                <select name="calculation_type" class="w-full border p-2 rounded">
                    <option value="fixed" @if($item->calculation_type=='fixed') selected @endif>Fixed</option>
                    <option value="formula" @if($item->calculation_type=='formula') selected @endif>Formula</option>
                    <option value="variable" @if($item->calculation_type=='variable') selected @endif>Variable</option>
                </select>
            </div>

            <!-- Payment Frequency -->
            <div>
                <label class="block font-semibold mb-1">Payment Frequency</label>
                <select name="payment_frequency" class="w-full border p-2 rounded">
                    <option value="once" @if($item->payment_frequency=='once') selected @endif>Once</option>
                    <option value="monthly" @if($item->payment_frequency=='monthly') selected @endif>Monthly</option>
                    <option value="quarterly" @if($item->payment_frequency=='quarterly') selected @endif>Quarterly</option>
                    <option value="annual" @if($item->payment_frequency=='annual') selected @endif>Annual</option>
                </select>
            </div>

            <!-- Penalty Rate -->
            <div>
                <label class="block font-semibold mb-1">Penalty Rate</label>
                <input type="number" name="penalty_rate" step="0.0001" value="{{ $item->penalty_rate }}" class="w-full border p-2 rounded">
            </div>

            <!-- Active -->
            <div>
                <label class="block font-semibold mb-1">Active</label>
                <select name="is_active" class="w-full border p-2 rounded">
                    <option value="1" @if($item->is_active) selected @endif>Yes</option>
                    <option value="0" @if(!$item->is_active) selected @endif>No</option>
                </select>
            </div>

            <!-- Description (full width) -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ $item->description }}</textarea>
            </div>

        </div>

        <div class="mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Item</button>
        </div>
    </form>
</div>
@endsection
