@extends('admin.layouts.app')

@section('title', 'Add Revenue Category')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Add Revenue Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="form-checkbox">
                <span class="ml-2">Active</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Category</button>
    </form>
</div>
@endsection
