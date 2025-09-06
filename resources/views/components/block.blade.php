<div {{ $attributes->merge(['class' => "col my-3 mx-2 p-2 bg-light text-dark rounded border shadow" ]) }}>
    @isset($heading)
        <h3 class="text-lg font-medium text-gray-900 text-primary">
            {{ $heading }}
        </h3>
    @endisset
    {{ $slot }}
</div>
