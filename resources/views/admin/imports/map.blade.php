@extends('admin.layouts.app')

@section('title', 'Map Columns')
@section('page-title', 'Map Columns')

@section('content')
@php
    $existingMap = is_array($import->mapping_json ?? null) ? $import->mapping_json : [];

    $pickDefault = function(string $field) use ($headers, $suggested, $existingMap) {
        if (!empty($existingMap[$field])) return $existingMap[$field];

        $candidates = $suggested[$field] ?? [];
        $lowerHeaders = array_map(fn($h) => mb_strtolower(trim((string) $h)), $headers);

        foreach ($candidates as $cand) {
            $cand = mb_strtolower(trim((string) $cand));
            $idx = array_search($cand, $lowerHeaders, true);
            if ($idx !== false) return $headers[$idx];
        }
        return '';
    };
@endphp

<div class="max-w-5xl mx-auto space-y-6">

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4">
            <p class="font-semibold mb-2">Fix these mapping issues</p>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Map File Columns</h2>
            <p class="text-sm text-gray-500 mt-1">
                Import ID {{ $import->id }} • {{ $import->original_filename }}
            </p>
        </div>

        <form action="{{ route('admin.imports.map.save', $import) }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($required as $field)
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            {{ str_replace('_', ' ', ucfirst($field)) }}
                        </label>

                        <select name="mapping[{{ $field }}]"
                                class="w-full border border-gray-300 rounded-xl p-3 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option value="">Select a column</option>
                            @foreach($headers as $h)
                                @php $sel = $pickDefault($field) === $h ? 'selected' : ''; @endphp
                                <option value="{{ $h }}" {{ $sel }}>{{ $h }}</option>
                            @endforeach
                        </select>

                        @error('mapping.'.$field)
                            <p class="text-xs text-red-600 mt-2 font-semibold">{{ $message }}</p>
                        @enderror

                        @error($field)
                            <p class="text-xs text-red-600 mt-2 font-semibold">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-500 mt-2">
                            Required
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.imports.index') }}"
                   class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Back
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Save Mapping
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Detected Columns</h3>
            <p class="text-sm text-gray-500 mt-1">These are the headers found in row 1</p>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-2">
                @forelse($headers as $h)
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-semibold border border-blue-100">
                        {{ $h }}
                    </span>
                @empty
                    <p class="text-sm text-gray-500">No headers detected</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
