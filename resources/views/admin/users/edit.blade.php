@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Role</label>
            <select name="role" class="w-full border rounded p-2">
                @php $role = old('role', $user->role); @endphp
                <option value="user" {{ $role === 'user' ? 'selected' : '' }}>User</option>
                <option value="collector" {{ $role === 'collector' ? 'selected' : '' }}>Collector</option>
                <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super-admin" {{ $role === 'super-admin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">New Password (optional)</label>
            <input type="password" name="password" class="w-full border rounded p-2">
            <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password.</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">
                Update User
            </button>

            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
