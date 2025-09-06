<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seat {{ $seat->serial }} in room: {{ $seat->room->roomno }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $seat->room->id }}/seat">back</a>
                    <a class="btn btn-secondary btn-sm" href="/seat/{{ $seat->id }}/edit">Edit</a>
                    <button class="btn btn-danger btn-sm delete">Delete</button>
                    <a class="btn btn-secondary btn-sm" href="/seat/{{ $seat->id }}/remark">Remark</a>
                </p>
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Current status
            </x-slot>
            <div class="form-group row mb-3">
                <label class="col col-md-4">Whether available?</label>
                <div class="col col-md-4">{{ $seat->available? 'Yes':'No' }}</div>
            </div>

        </x-block>
    </x-container>
    @if(count($seat->remarks))
        <x-container>
            <x-block>
                <x-slot name="heading">
                    Seat Remarks
                </x-slot>
                <div>
                    <ul>
                        @foreach($seat->remarks as $rm)
                            <li>{{ $rm->remark_dt }}: {{ $rm->remark }}</li>
                        @endforeach
                    </ul>
                </div>

            </x-block>
        </x-container>
    @endif

<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

    $("button.delete").click(function(){
        if(confirm("Are you sure you want to delete the seat?")){
            $.ajax({
                url : "/seat/{{ $seat->id }}",
                type : "delete",
                success : function(data,status){

                    alert("Deleted");
                    location.replace("/room/{{ $seat->room->id }}/seat");
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });
});
</script>
</x-layout>
