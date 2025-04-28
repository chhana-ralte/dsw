<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                User: {{ $user->name }}
            </x-slot>
            
            <div class="form-group row pt-2">
                <div class="col-md-3">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" disabled>
                </div>
            </div>

            <div class="form-group row pt-2">
                <div class="col-md-3">
                    <label for="username">Username</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="username" value="{{$user->username}}" disabled>
                </div>
            </div>

{{--            <div class="form-group row pt-2">
                <div class="col-md-3">
                    <label for="email">Email</label>
                </div>
                <div class="col-md-4">
                    <input type="email" class="form-control" name="email" value="{{$user->email}}" disabled>
                </div>
            </div>--}}

            <div class="form-group row pt-2">
                <div class="col-md-3">
                    Roles
                </div>
                <div class="col-md-4">
                    @foreach($user->roles as $rl)
                        {{ $rl->role }}<br>
                    @endforeach

                </div>
            </div>
            <div class="form-group row pt-2">
                <div class="col-md-3">
                </div>
                <div class="col-md-4">
                    <x-button type="a" href="/user">Back</x-button>
                    <x-button type="a" href="/user/{{ $user->id }}/edit">Edit</x-button>
                </div>
            </div>
            
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("button.btn-delete").click(function(){
        if(confirm('Are you sure you want to delete?')){
            
        }
    });
})
</script>
</x-layout>
