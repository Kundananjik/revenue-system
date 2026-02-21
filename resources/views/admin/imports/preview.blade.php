@extends('layouts.app')

@section('title', 'Preview Import')
@section('page-title', 'Preview Import')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <p class="font-semibold">Total Rows</p>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ (int) $import->total_rows }}</p>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <p class="font-semibold">Valid Rows</p>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ (int) $import->valid_rows }}</p>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <p class="font-semibold">Invalid Rows</p>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ (int) $import->invalid_rows }}</p>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <p class="font-semibold">Ready</p>
                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-4">{{ $import->invalid_rows == 0 ? 'Yes' : 'Fix' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Preview Result</h2>
                <p class="text-sm text-gray-500 mt-1">Import ID {{ $import->id }} • {{ $import->original_filename }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.imports.map', $import) }}"
                   class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Edit Mapping
                </a>

                <form action="{{ route('admin.imports.run', $import) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition disabled:opacity-60"
                            {{ $import->valid_rows < 1 ? 'disabled' : '' }}>
                        Import Now
                    </button>
                </form>
            </div>
        </div>

        <div class="p-6">
            @if($import->invalid_rows > 0)
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6">
                    <p class="font-semibold">Some rows are invalid</p>
                    <p class="text-sm mt-1">Fix your CSV and upload again, or adjust mapping</p>
                </div>
            @else
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6">
                    <p class="font-semibold">All rows look valid</p>
                    <p class="text-sm mt-1">You can import now</p>
                </div>
            @endif

            <h3 class="text-lg font-bold text-gray-900 mb-3">Invalid Row Sample</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Row</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Errors</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($invalidSample as $r)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $r->row_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <pre class="text-xs bg-gray-50 border border-gray-200 rounded-xl p-3 overflow-x-auto">{{ json_encode($r->mapped_json ?? $r->raw_json, JSON_PRETTY_PRINT) }}</pre>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <pre class="text-xs bg-red-50 border border-red-200 rounded-xl p-3 overflow-x-auto text-red-800">{{ json_encode($r->errors_json, JSON_PRETTY_PRINT) }}</pre>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10 text-center text-sm text-gray-500">
                                    No invalid rows to show
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-ui.table>

        </div>
    </div>

</div>
@endsection




