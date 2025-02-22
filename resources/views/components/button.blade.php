@props(['type'=>'button','selected'=>'false'])

@if($type == 'a')
    @if($selected =='true')
        <a {{ $attributes->merge(['class' => 'btn btn-secondary']) }}>
            {{ $slot }}
        </a>
    @else
        <a {{ $attributes->merge(['class' => 'btn btn-outline-secondary']) }}>
            {{ $slot }}
        </a>
    @endif
@elseif($type == "button")
    <button {{ $attributes->merge(['class' => 'btn btn-secondary']) }}>
        {{ $slot }}
    </button>
@elseif($type == 'delete')
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger']) }}>
        {{ $slot }}
    </button>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary']) }}>
        {{ $slot }}
    </button>
@endif