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
                Edit
            </x-slot>
            <form method="post" action="/room/{{ $room->id }}">
                @method("PUT")
                @csrf
                <div class="form-group row mb-3">
                    <label for="roomno" class="col col-md-3">Room No.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="roomno" value="{{ $room->roomno }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="roomno" class="col col-md-3">Room No.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="roomno" value="{{ $room->roomno }}" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="capacity" class="col col-md-3">Capacity</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="capacity" value="{{ $room->capacity }}" required>
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

        @if(count($room->ex_allot_seats()) > 0)
        <x-block>
            <x-slot name="heading">
                Ex-Occupants
            </x-slot>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    <tr>
                        <th>Seat sl.</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>MZU ID</th>
                    </tr>
                    @foreach($room->ex_allot_seats() as $as)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $as->seat->serial }}</td>
                        <td>{{ $as->allot_hostel->person->name }}</td>
                        @if($as->allot_hostel->person->student())
                            <td>{{ $as->allot_hostel->person->student()->course }}</td>
                            <td>{{ $as->allot_hostel->person->student()->department }}</td>
                            <td>{{ $as->allot_hostel->person->student()->mzuid }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-block>
        @endif


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
