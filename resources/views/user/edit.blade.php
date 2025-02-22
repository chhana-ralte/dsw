<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                User: {{ $user->name }}
            </x-slot>
            <form method="post" action="/user/{{$user->id}}" class="pt-2">
                @csrf
                @method('patch')
                <input type="hidden" id="department_user" value="{{ $user->hasRole('Department')?'true':'false' }}">
                <input type="hidden" id="teacher_user" value="{{ $user->hasRole('Teacher')?'true':'false' }}">

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="username" value="{{$user->username}}" required>
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" required>
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        Roles
                    </div>
                    <div class="col-md-4">
                        @foreach(\App\Models\Role::all() as $rl)
                            <input type="checkbox" id="{{ $rl->id }}" name="roles[]" value="{{ $rl->id }}" {{$user->hasRole($rl->role)?' checked ':''}}>
                            <label for="{{ $rl->id }}">{{ $rl->role}}</label><br>
                        @endforeach

                    </div>
                </div>
                <div class="form-group row pt-2 department">
                    <div class="col-md-3">
                        <label for="email">Department</label>
                    </div>
                    <div class="col-md-4">
                        <select name="department" class="form-control">
                            <option value="0">Select Department</option>
                            @foreach(\App\Models\Department::orderBy('name')->get() as $dept)
                                <option value="{{ $dept->id }}" {{ $dept->id==$user->department_id?' selected ':''}}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                

                <div class="form-group row pt-2 teacher">
                    <div class="col-md-3">
                        <label for="teacher">Teacher</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="teacher" id="teacher">
                            <option value="0">Select Teacher</option>
                            @foreach(\App\Models\Teacher::all() as $t)
                                <option value="{{ $t->id }}" {{ $t->id==$user->teacher_id?' selected ':''}}>{{ $t->person->name . ' : ' . $t->department->name }}</option>
                            @endforeach
                        </select>
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

    if($("input#department_user").val()=="false"){
        $("div.department").hide();
    }

    if($("input#teacher_user").val()=="false"){
        $("div.teacher").hide();
    }

    $("input[type='checkbox']").click(function(){
        var checked = $(this).is(':checked');
        $.ajax({
            url : "/role/" + $(this).attr('id') + '?checked=' + checked,
            type : "get",
            success : function(data,status){
                if(data.role == "Department"){
                    if(data.checked == 'true'){
                        $("div.department").show();
                    }
                    else{
                        $("div.department").hide();
                    }
                }
                else if(data.role == "Teacher"){
                    if(data.checked == 'true'){
                        $("div.teacher").show();
                    }
                    else{
                        $("div.teacher").hide();
                    }
                }
            },
            error : function(){
                alert("Error");
            }
        });
    });
    $("button.btn-delete").click(function(){
        if(confirm('Are you sure you want to delete?')){
            
        }
    });
})
</script>
</x-layout>
