<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                    Editing room No.: {{ $room->roomno }} of {{ $room->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}">back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Editing room details
            </x-slot>
            <form method="post" action="/room/{{ $room->id }}">
                @method("PUT")
                @csrf
                <div class="form-group row mb-3">
                    <label for="roomno" class="col col-md-3">Room No.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="roomno" value="{{ old('roomno',$room->roomno) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="capacity" class="col col-md-3">Capacity</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="capacity" value="{{ $room->capacity }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="available" class="col col-md-3">Available seats</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="available" value="{{ $room->available }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button class="btn btn-primary" type="submit" id="update">Update</update>
                    </div>
                </div>
            </form>
        </x-block>


    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

    $("a.deallocate").click(function(){
        if(confirm("Are you sure you want to deallocate this student from the existing seat?")){
            $.ajax({
                type : "post",
                url : "/ajax/seat/" + $(this).attr("id") + "/deallocate",
                
                success : function(data,status){
                    if(data == "Success"){
                        alert("Deallocation successful");
                        location.replace("/room/{{ $room->id }}");
                    }
                },
                error : function(){
                    alert("Error");
                }
            });
        }
        //alert($(this).attr('id'));
    });
});
</script>
</x-layout>
