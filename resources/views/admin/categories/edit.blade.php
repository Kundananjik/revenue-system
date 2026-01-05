@extends('admin.layouts.app')

@section('title', 'Edit Revenue Category')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Revenue Category</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border p-2 rounded">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Slug (optional) -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full border p-2 rounded">
                @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Active -->
            <div>
                <label class="block font-semibold mb-1">Active</label>
                <select name="is_active" class="w-full border p-2 rounded">
                    <option value="1" @if($category->is_active) selected @endif>Yes</option>
                    <option value="0" @if(!$category->is_active) selected @endif>No</option>
                </select>
            </div>

        </div>

        <div class="mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Category</button>
        </div>
    </form>
</div>
@endsection
