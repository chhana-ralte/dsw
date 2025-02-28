<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                    Room No.: {{ $room->roomno }} of {{ $room->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $room->hostel->id }}/room">Back</a>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/edit">Edit</a>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/remark">Remark</a>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/seat">Seats</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Current occupants
            </x-slot>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    <tr>
                        <th>Seat sl.</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>MZU ID</th>
                        <th>Allot</th>
                    </tr>
                    @foreach($seats as $s)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/seat/{{ $s->id }}">{{ $s->serial }}</a></td>
                        @if( count($s->active_allot_seats()) > 0)
                            @foreach($s->active_allot_seats() as $as)
                                <td>{{ $as->allot_hostel->person->name }}</td>
                                @if($as->allot_hostel->person->student())
                                    <td>{{ $as->allot_hostel->person->student()->course }}</td>
                                    <td>{{ $as->allot_hostel->person->student()->department }}</td>
                                    <td>{{ $as->allot_hostel->person->student()->mzuid }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            @endforeach

                        @else
                            <td colspan="4">Seat Vacant</td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ...
                                </a>
                                <ul class="dropdown-menu">
                                    @if( count($s->active_allot_seats()) > 0)
                                        <li><a class="dropdown-item" href="/seat/{{ $s->id }}/allotSeat">Allot another</a></li>
                                        <li><a class="dropdown-item deallocate" href="#" id="{{ $s->id }}">Deallocate</a></li>
                                    @else
                                        <li><a class="dropdown-item" href="/seat/{{ $s->id }}/allotSeat">Allot</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
