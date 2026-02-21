@props([
    'type' => 'info', // info | success | warning | danger
])

@php
    $base = 'rounded-xl border px-4 py-3 shadow-sm text-sm flex items-start justify-between gap-3';
    $types = [
        'info' => 'border-blue-200 bg-blue-50 text-blue-800',
        'success' => 'border-green-200 bg-green-50 text-green-800',
        'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
        'danger' => 'border-red-200 bg-red-50 text-red-800',
    ];
    $classes = $base.' '.($types[$type] ?? $types['info']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex items-start gap-2">
        {{ $slot }}
    </div>

    @if ($attributes->has('dismissable'))
        <button type="button" onclick="this.parentElement.remove()" class="opacity-70 hover:opacity-100" aria-label="Dismiss">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    @endif
</div>
