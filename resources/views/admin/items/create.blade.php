@extends('admin.layouts.app')

@section('title', 'Create Revenue Item')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Create Revenue Item</h1>

    <form action="{{ route('admin.items.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Category -->
            <div>
                <label class="block font-semibold mb-1">Category</label>
                <select name="category_id" class="w-full border p-2 rounded">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Name -->
            <div>
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Code -->
            <div>
                <label class="block font-semibold mb-1">Code</label>
                <input type="text" name="code" value="{{ old('code') }}" class="w-full border p-2 rounded">
                @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Amount -->
            <div>
                <label class="block font-semibold mb-1">Amount</label>
                <input type="number" name="amount" step="0.01" value="{{ old('amount') }}" class="w-full border p-2 rounded">
                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Calculation Type -->
            <div>
                <label class="block font-semibold mb-1">Calculation Type</label>
                <select name="calculation_type" class="w-full border p-2 rounded">
                    <option value="fixed" @if(old('calculation_type')=='fixed') selected @endif>Fixed</option>
                    <option value="formula" @if(old('calculation_type')=='formula') selected @endif>Formula</option>
                    <option value="variable" @if(old('calculation_type')=='variable') selected @endif>Variable</option>
                </select>
                @error('calculation_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Payment Frequency -->
            <div>
                <label class="block font-semibold mb-1">Payment Frequency</label>
                <select name="payment_frequency" class="w-full border p-2 rounded">
                    <option value="once" @if(old('payment_frequency')=='once') selected @endif>Once</option>
                    <option value="monthly" @if(old('payment_frequency')=='monthly') selected @endif>Monthly</option>
                    <option value="quarterly" @if(old('payment_frequency')=='quarterly') selected @endif>Quarterly</option>
                    <option value="annual" @if(old('payment_frequency')=='annual') selected @endif>Annual</option>
                </select>
                @error('payment_frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Penalty Rate -->
            <div>
                <label class="block font-semibold mb-1">Penalty Rate</label>
                <input type="number" name="penalty_rate" step="0.0001" value="{{ old('penalty_rate',0) }}" class="w-full border p-2 rounded">
                @error('penalty_rate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Active -->
            <div>
                <label class="block font-semibold mb-1">Active</label>
                <select name="is_active" class="w-full border p-2 rounded">
                    <option value="1" @if(old('is_active',1)==1) selected @endif>Yes</option>
                    <option value="0" @if(old('is_active',1)==0) selected @endif>No</option>
                </select>
                @error('is_active') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Description (full width) -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Item</button>
        </div>
    </form>
</div>
@endsection
