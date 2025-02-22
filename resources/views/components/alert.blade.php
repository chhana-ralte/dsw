@props(['type'=>'info'])

<div class="alert alert-{{$type}}">
    <strong align="center">{{$slot}}</strong>
</div>