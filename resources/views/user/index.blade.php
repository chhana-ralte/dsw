<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of users
                <p>
                    <a class="btn btn-primary btn-sm" href="/user/create">New user</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                
                <div class="pt-2">
                @if(count($users)>0)
                
                    <table class="table table-striped pt-2">
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit|Delete</th>
                        </tr>
                        <?php $sl=1 ?>
                        @foreach($users as $u)
                            @if($u->max_role_level() < auth()->user()->max_role_level())
                            <tr>
                                
                                <td>{{ $sl++ }}</td>
                                <td><a href="/user/{{$u->id}}">{{ $u->name }}</a></td>
                                <td>{{ $u->username }}</td>
                                <td>
                                    <div class="btn-group">
                                        <x-button type="a" href="/user/{{$u->id}}/edit">Edit</x-button>
                                        <x-button type="delete" class="delete" value="{{$u->id}}">Delete</x-button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                    @else
                        No user
                    @endif
                    <form method="post" id="form-delete">
                        @csrf
                        @method('delete')
                    </form>
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
    $("button.delete").click(function(){
        if(confirm('Are you sure you want to delete?')){
            $("form#form-delete").attr('action','/user/' + $(this).val());
            $("form#form-delete").submit();
        }
    });
})
</script>
</x-layout>
