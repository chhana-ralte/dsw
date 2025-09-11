<div {{ $attributes->merge(['class' => 'p-2']) }}>
    <div class="p-2 my-2 border rounded shadow bg-light text-dark">
        @isset($heading)
            <h3 class="text-lg font-medium text-gray-900 text-primary">
                {{ $heading }}
            </h3>
        @endisset
        {{ $slot }}
    </div>
</div>
