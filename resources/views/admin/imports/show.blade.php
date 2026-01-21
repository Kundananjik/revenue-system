@extends('admin.layouts.app')

@section('title', 'Import Details')
@section('page-title', 'Import Details')

@section('content')
@php
    $statusPill = match($stats['status'] ?? '') {
        'uploaded' => 'bg-gray-100 text-gray-800',
        'mapped' => 'bg-blue-100 text-blue-800',
        'previewed' => 'bg-yellow-100 text-yellow-800',
        'importing' => 'bg-purple-100 text-purple-800',
        'completed' => 'bg-green-100 text-green-800',
        'failed' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-900">Import ID {{ $import->id }}</h2>
                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $statusPill }}">
                        {{ ucfirst($import->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">{{ $import->original_filename }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.imports.index') }}"
                   class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Back
                </a>

                @if(in_array($import->status, ['uploaded','mapped'], true))
                    <a href="{{ route('admin.imports.map', $import) }}"
                       class="px-4 py-2 rounded-xl border border-blue-200 text-blue-700 font-semibold hover:bg-blue-50 transition">
                        Map
                    </a>
                @endif

                @if(in_array($import->status, ['mapped','previewed'], true))
                    <a href="{{ route('admin.imports.preview', $import) }}"
                       class="px-4 py-2 rounded-xl border border-yellow-200 text-yellow-800 font-semibold hover:bg-yellow-50 transition">
                        Preview
                    </a>
                @endif
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ (int) ($stats['total'] ?? 0) }}</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4">
                <p class="text-xs font-semibold text-green-700 uppercase tracking-wider">Valid</p>
                <p class="text-2xl font-bold text-green-800 mt-2">{{ (int) ($stats['valid'] ?? 0) }}</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
                <p class="text-xs font-semibold text-red-700 uppercase tracking-wider">Invalid</p>
                <p class="text-2xl font-bold text-red-800 mt-2">{{ (int) ($stats['invalid'] ?? 0) }}</p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Imported</p>
                <p class="text-2xl font-bold text-blue-800 mt-2">{{ (int) ($stats['imported'] ?? 0) }}</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4">
                <p class="text-xs font-semibold text-yellow-700 uppercase tracking-wider">Skipped</p>
                <p class="text-2xl font-bold text-yellow-800 mt-2">{{ (int) ($stats['skipped'] ?? 0) }}</p>
            </div>
        </div>

        @if($import->status === 'failed' && $import->error_message)
            <div class="p-6 pt-0">
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4">
                    <p class="font-semibold">Import failed</p>
                    <p class="text-sm mt-2 break-words">{{ $import->error_message }}</p>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Invalid Rows</h3>
                <p class="text-sm text-gray-500 mt-1">Rows blocked by validation</p>
            </div>

            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Row</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Errors</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($invalidRows as $r)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $r->row_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <pre class="text-xs bg-red-50 border border-red-200 rounded-xl p-3 overflow-x-auto text-red-800">{{ json_encode($r->errors_json, JSON_PRETTY_PRINT) }}</pre>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-10 text-center text-sm text-gray-500">No invalid rows</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $invalidRows->links() }}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Skipped Rows</h3>
                <p class="text-sm text-gray-500 mt-1">Usually duplicates by reference</p>
            </div>

            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Row</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($skippedRows as $r)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $r->row_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <pre class="text-xs bg-gray-50 border border-gray-200 rounded-xl p-3 overflow-x-auto">{{ json_encode($r->mapped_json ?? $r->raw_json, JSON_PRETTY_PRINT) }}</pre>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-10 text-center text-sm text-gray-500">No skipped rows</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $skippedRows->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
