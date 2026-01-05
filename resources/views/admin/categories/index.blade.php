@extends('admin.layouts.app')

@section('title', 'Revenue Categories')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Revenue Categories</h1>
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
           + Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Active</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $category->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $category->description }}</td>
                        <td class="px-4 py-3">
                            @if($category->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2 flex items-center">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="text-blue-500 hover:underline hover:text-blue-700 transition">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline hover:text-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 font-medium">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
