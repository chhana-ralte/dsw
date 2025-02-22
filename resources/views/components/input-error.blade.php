@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div {{ $attributes->merge(['class' => 'small text-danger dark:text-danger']) }}>
            {{ $message }}
        </div>
    @endforeach
@endif
