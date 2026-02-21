@extends('layouts.app')

@section('title', 'Imports')
@section('page-title', 'Imports')

@section('header-actions')
    <a href="{{ route('admin.imports.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        New Import
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Import Batches</h2>
                <p class="text-sm text-gray-500 mt-1">Upload, map, preview, then import safely</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rows</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($imports as $imp)
                        @php
                            $pill = match($imp->status) {
                                'uploaded' => 'bg-gray-100 text-gray-800',
                                'mapped' => 'bg-blue-100 text-blue-800',
                                'previewed' => 'bg-yellow-100 text-yellow-800',
                                'importing' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'failed' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">{{ $imp->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $imp->type) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="font-medium text-gray-900 truncate max-w-[340px]">{{ $imp->original_filename }}</div>
                                <div class="text-xs text-gray-500 mt-1 truncate max-w-[340px]">{{ $imp->stored_path }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $pill }}">
                                    {{ ucfirst($imp->status) }}
                                </span>
                                @if($imp->status === 'failed' && $imp->error_message)
                                    <div class="text-xs text-red-600 mt-2 max-w-[300px] truncate" title="{{ $imp->error_message }}">
                                        {{ $imp->error_message }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-semibold">{{ (int) $imp->total_rows }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Valid {{ (int) $imp->valid_rows }} • Invalid {{ (int) $imp->invalid_rows }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-medium text-gray-900">{{ optional($imp->created_at)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ optional($imp->created_at)->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="{{ route('admin.imports.show', $imp) }}"
                                   class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                                    View
                                </a>

                                @if(in_array($imp->status, ['uploaded','mapped'], true))
                                    <a href="{{ route('admin.imports.map', $imp) }}"
                                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition">
                                        Map
                                    </a>
                                @endif

                                @if(in_array($imp->status, ['mapped','previewed'], true))
                                    <a href="{{ route('admin.imports.preview', $imp) }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-yellow-200 text-yellow-800 font-semibold hover:bg-yellow-50 transition ml-2">
                                        Preview
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-5 h-5 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="font-semibold text-gray-700">No imports yet</p>
                                    <p class="text-sm mt-1">Create an import batch to upload data</p>
                                    <a href="{{ route('admin.imports.create') }}"
                                       class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                                        New Import
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-ui.table>

        <div class="p-6 border-t border-gray-100">
            {{ $imports->links() }}
        </div>
    </div>
</div>
@endsection




