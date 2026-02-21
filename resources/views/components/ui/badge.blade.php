@props([
    'type' => 'neutral', // neutral | success | warning | danger | info
])

@php
    $base = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold';
    $types = [
        'neutral' => 'bg-gray-100 text-gray-800',
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
        'info' => 'bg-blue-100 text-blue-800',
    ];
    $classes = $base.' '.($types[$type] ?? $types['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
