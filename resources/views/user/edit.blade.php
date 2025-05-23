<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                User: {{ $user->name }}
            </x-slot>
            <form method="post" action="/user/{{$user->id}}" class="pt-2">
                @csrf
                @method('patch')
                <input type='hidden' name='warden' value='{{ $user->hasRole("Warden")?"true":"false" }}'>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="username" value="{{ old('username',$user->username) }}" required>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="password" value="">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @else
                            <span class="text-danger">Enter only if you want to reset password. Leave blank if password is to be retained.</span>
                        @enderror

                    </div>
                </div>
{{--                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" required>
                    </div>
                </div>
--}}

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        Roles
                    </div>
                    <div class="col-md-4">
                        @if(auth()->user()->isAdmin())
                            @foreach($roles as $rl)
                                <input type="checkbox" id="role_{{ $rl->id }}" name="roles[]" value="{{ $rl->id }}" {{ $user->hasRole("$rl->role")?' checked ':'' }}>
                                <label for="role_{{ $rl->id }}">{{ $rl->role}}</label><br>
                            @endforeach
                        @elseif(auth()->user()->isDsw())
                            @foreach($roles as $rl)
                                @if(auth()->user()->max_role_level() > $rl->level && $rl->level >=3)
                                    <input type="checkbox" id="role_{{ $rl->id }}" name="roles[]" value="{{ $rl->id }}" {{ $user->hasRole("$rl->role")?' checked ':'' }}>
                                    <label for="role_{{ $rl->id }}">{{ $rl->role}}</label><br>
                                @endif
                            @endforeach
                        @elseif(auth()->user()->isWarden())
                            @foreach($roles as $rl)
                                @if(auth()->user()->max_role_level() > $rl->level && $rl->level)
                                    <input type="checkbox" id="role_{{ $rl->id }}" name="roles[]" value="{{ $rl->id }}" {{ $user->hasRole("$rl->role")?' checked ':'' }}>
                                    <label for="role_{{ $rl->id }}">{{ $rl->role}}</label><br>
                                @endif
                            @endforeach
                        @endif
                        @error('roles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2 hostel">
                    <div class="col-md-3">
                        <label for="hostel">Hostel</label>
                    </div>
                    <div class="col-md-4">
                        @if(auth()->user()->isAdmin() || auth()->user()->isDSW())
                            @foreach(\App\Models\Hostel::orderBy('name')->get() as $hostel)
                                <input id="hostel_{{ $hostel->id }}" type="checkbox" name="hostel[]" value="{{ $hostel->id }}" {{ $user->isWardenOf($hostel->id)?" checked ":""}}>
                                <label for="hostel_{{ $hostel->id }}">{{ $hostel->name}}</label><br>
                            @endforeach
                        @elseif(auth()->user()->isWarden())
                            @foreach(\App\Models\Hostel::orderBy('name')->get() as $hostel)
                                @if(auth()->user()->isWardenOf($hostel->id))
                                    <input id="hostel_{{ $hostel->id }}" type="checkbox" name="hostel[]" value="{{ $hostel->id }}" {{ $user->isPrefectOf($hostel->id)||$user->isMessSecretaryOf($hostel->id)?" checked ":""}}>
                                    <label for="hostel_{{ $hostel->id }}">{{ $hostel->name}}</label><br>
                                @endif
                            @endforeach
                        @endif
                        @error('selectHostel')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row pt-2">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-4">
                        <x-button type="a" href="/user">Back</x-button>
                        <x-button type="submit">Update</x-button>
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

    if($("input[name='warden']").val()=="false" && $("input[name='prefect']").val()=="false" && $("input[name='mess secretary']").val()=="false" && ){
        $("div.hostel").hide();
    }

    $("input[name='roles[]']").click(function(){
        // alert($(this).attr('name'));
        var checked = $(this).is(':checked');
        if(checked){
            $.ajax({
                url : "/ajax/get_role/" + $(this).val(),
                type : "get",
                success : function(data,status){
                    if(data.role == 'Warden' || data.role == 'Prefect' || data.role == 'Mess Secretary'){
                        $("div.hostel").show();
                    }
                },
                error : function(){
                    alert("Error occured");
                }
            });
        }
        else{
            $("div.hostel").hide();
        }


        // $.ajax({
        //     url : "/role/" + $(this).attr('id') + '?checked=' + checked,
        //     type : "get",
        //     success : function(data,status){
        //         if(data.role == "Department"){
        //             if(data.checked == 'true'){
        //                 $("div.department").show();
        //             }
        //             else{
        //                 $("div.department").hide();
        //             }
        //         }
        //         else if(data.role == "Teacher"){
        //             if(data.checked == 'true'){
        //                 $("div.teacher").show();
        //             }
        //             else{
        //                 $("div.teacher").hide();
        //             }
        //         }
        //     },
        //     error : function(){
        //         alert("Error");
        //     }
        // });
    });
    $("button.btn-delete").click(function(){
        if(confirm('Are you sure you want to delete?')){

        }
    });
})
</script>
</x-layout>
