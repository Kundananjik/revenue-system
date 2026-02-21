@props([
    'title' => 'No results found',
    'message' => '',
])

<div class="flex flex-col items-center justify-center text-center text-gray-500 py-12">
    <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <p class="text-lg font-medium mb-1">{{ $title }}</p>
    @if ($message !== '')
        <p class="text-sm text-gray-400 mb-4">{{ $message }}</p>
    @endif

    @isset($action)
        <div>
            {{ $action }}
        </div>
    @endisset
</div>
