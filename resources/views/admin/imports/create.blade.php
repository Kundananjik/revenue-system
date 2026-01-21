@extends('admin.layouts.app')

@section('title', 'New Import')
@section('page-title', 'New Import')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4">
            <p class="font-semibold mb-2">Fix these errors</p>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Upload File</h2>
            <p class="text-sm text-gray-500 mt-1">CSV only for now</p>
        </div>

        <form action="{{ route('admin.imports.upload') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Import Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="payments" {{ old('type') === 'payments' ? 'selected' : '' }}>Payments</option>
                </select>
                <p class="text-xs text-gray-500 mt-2">More types can be added later</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">CSV File</label>
                <input type="file" name="file" accept=".csv,.txt"
                       class="w-full border border-gray-300 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300" />
                <p class="text-xs text-gray-500 mt-2">Max 20MB</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.imports.index') }}"
                   class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
