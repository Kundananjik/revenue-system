<div class="bg-white rounded-xl border border-gray-200 shadow-sm">
    <div class="px-4 pt-3 text-[11px] font-medium uppercase tracking-wide text-gray-400 sm:hidden">
        Swipe to view full table
    </div>
    <div class="overflow-x-auto overscroll-x-contain">
        <table {{ $attributes->merge(['class' => 'w-full min-w-[720px] divide-y divide-gray-200 text-sm']) }}>
            {{ $slot }}
        </table>
    </div>
</div>
