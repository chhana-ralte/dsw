@props(['type'=>'info'])

<div class="alert alert-{{$type}}">
    <p class="h4 text-center">{{ $slot }}</p>
    {{-- <strong align="center">{{$slot}}</strong> --}}
</div>
