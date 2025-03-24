<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Change password for: {{ auth()->user()->name }}
            </x-slot>
            <form method="post" action="/user/changePassword" class="pt-2">
                @csrf
                
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

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" disabled>
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        New Password
                    </div>
                    <div class="col-md-4">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        Confirm Password
                    </div>
                    <div class="col-md-4">
                        <input type="password" class="form-control" name="confirm_password" required>
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-4">
                        <x-button type="a" href="/">Home</x-button>
                        <x-button type="submit">Change password</x-button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
});
</script>
</x-layout>
