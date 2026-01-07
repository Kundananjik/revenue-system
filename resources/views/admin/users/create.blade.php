@extends('admin.layouts.app')

@section('title','Add User')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add User</h2>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="user">User</option>
                <option value="collector">Collector</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input name="password" type="password" class="w-full border rounded p-2" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Create User
        </button>
    </form>
</div>
@endsection
