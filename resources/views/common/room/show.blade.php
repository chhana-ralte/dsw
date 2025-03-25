<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Room No.: {{ $room->roomno }} of {{ $room->hostel->name }}
                <p>
                <div class="pl-3 row justify-content-between">
                    <div class="col-auto">
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $room->hostel->id }}/room">Back</a>

                    </div>
                </div>
                <div class="pl-3 mt-2">
                    @auth
                        @can('update',$room->hostel)
                            <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/edit">Edit</a>
                            <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/remark">Remark</a>
                            <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/seat">Seats</a>
                            <button class="btn btn-danger btn-sm delete">Delete</button>
                        @endcan
                    @endauth
                </div>
                </p>
            </x-slot>
        </x-block>


        <x-block>
            <x-slot name="heading">
                Current occupants
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover table-striped">
                    <tbody>
                        <tr>
                            <th>Seat sl.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            @auth
                                @can('update',$room->hostel)
                                    <th>Action</th>
                                @endcan
                            @endauth
                        </tr>
                        @foreach ($seats as $s)
                            <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                <td>{{ $s->serial }}</td>
                                @if (count($s->valid_allot_seats()) > 0)
                                    @foreach ($s->valid_allot_seats() as $as)
                                        <td>{{ $as->allot_hostel->person->name }}</td>
                                        @if ($as->allot_hostel->person->student())
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
                                    <td colspan="4">
                                        Seat Vacant
                                        @if($s->available < 1)
                                            (Unavailable)
                                        @endif
                                    </td>
                                @endif
                                @auth
                                    @can('update',$room->hostel)
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    ...
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                        href="/seat/{{ $s->id }}">View Seat</a>
                                                    </li>
                                                    @if (count($s->valid_allot_seats()) > 0)
                                                        <li><a class="dropdown-item"
                                                                href="/seat/{{ $s->id }}/allotSeat">Allot another</a>
                                                        </li>
                                                        <li><a class="dropdown-item deallocate" href="#"
                                                                id="{{ $s->id }}">Deallocate</a></li>
                                                    @elseif($s->available != 0)
                                                        <li><a class="dropdown-item"
                                                                href="/seat/{{ $s->id }}/allotSeat">Allot</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @endcan
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>

        @if (count($room->invalid_allot_seats()) > 0)
            <x-block>
                <x-slot name="heading">
                    Ex-Occupants
                </x-slot>
                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto table-hover table-striped">
                        <tbody>
                            <tr>
                                <th>Seat sl.</th>
                                <th>Name</th>
                                <th>Duration</th>
                                <th>Course</th>
                                <th>Department</th>
                                <th>MZU ID</th>
                            </tr>
                            @foreach ($room->invalid_allot_seats() as $as)
                                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                    <td>{{ $as->seat->serial }}</td>
                                    <td>{{ $as->allot_hostel->person->name }}</td>
                                    <td>{{ $as->from_dt }} - {{ $as->to_dt }}</td>
                                    @if ($as->allot_hostel->person->student())
                                        <td>{{ $as->allot_hostel->person->student()->course }}</td>
                                        <td>{{ $as->allot_hostel->person->student()->department }}</td>
                                        <td>{{ $as->allot_hostel->person->student()->mzuid }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-block>
        @endif

        @if (count($room->remarks) > 0)
            <x-block>
                <x-slot name="heading">
                    Remarks about the room
                </x-slot>
                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto table-hover table-striped">
                        <tbody>
                            <tr>
                                <th>Date of remark</th>
                                <th>Remark</th>
                            </tr>
                            @foreach ($room->remarks as $rm)
                                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                    <td>{{ $rm->remark_dt }}</td>
                                    <td>{{ $rm->remark }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-block>
        @endif

    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("a.deallocate").click(function() {
                if (confirm("Are you sure you want to deallocate this student from the existing seat?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/seat/" + $(this).attr("id") + "/deallocate",

                        success: function(data, status) {
                            if (data == "Success") {
                                alert("Deallocation successful");
                                location.replace("/room/{{ $room->id }}");
                            }
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }
                //alert($(this).attr('id'));
            });

            $("button.delete").click(function() {
                if (confirm("Are you sure you want to delete the room?")) {
                    $.ajax({
                        url: "/room/{{ $room->id }}",
                        type: "delete",
                        success: function(data, status) {

                            alert("Deleted");
                            location.replace("/hostel/{{ $room->hostel->id }}/room");
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }
            });
        });
    </script>
</x-layout>
