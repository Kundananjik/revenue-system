<div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
        {{ $slot }}
    </table>
</div>
