<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Rooms in {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">back</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/room">All rooms</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/room?status=vacant">Vacant rooms/seats</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/room?status=non-available">Non-available rooms/seats</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/room/create">Create new room</a>
                </p>
            </x-slot>
            @if($status == "all")
                @if(count($rooms)>0)
                    <table class="table table-hover table-auto">
                        <thead>
                            <tr>
                                <th>Room No</th><th>Capacity</th><th>Available</th><th>Filled</th><th>Vacancy</th><th>Manage</th><th>Remarks</th><tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $r)
                                @if($r->capacity == $r->available)
                                    <tr class="table-default">
                                @else
                                    <tr class="table-danger">
                                @endif

                                <td><a href="/room/{{ $r->id }}">{{ $r->roomno }}</a></td>
                                <td>{{ $r->capacity }}</td>
                                <td>{{ $r->available }}</td>
                                <td>{{ $r->filled()->count() }}</td>
                                <td>{{ $r->available - $r->filled()->count() }}</td>
                                <td>
                                    @if(count($r->remarks))
                                        <ul>
                                        @foreach($r->remarks as $rm)
                                            <li>{{ $rm->remark_dt }}: {{ $rm->remark }}</li>
                                        @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            ...
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/room/{{ $r->id }}/remark">Remark</a></li>
                                            <li><a class="dropdown-item" href="/room/{{ $r->id }}/delete">Delete Room</a></li>
                                            <li><a class="dropdown-item" href="/room/{{ $r->id }}/edit">Edit Room</a></li>
                                            </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    No Room available
                @endif
            @elseif($status == 'vacant')
                @if(count($vacant_seats) > 0)
                    <table class="table table-hover table-auto">
                        <thead>
                            <tr>
                                <th>Seat No.</th><th>Remarks</th><tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vacant_seats as $s)
                                @if($s->available == 0)
                                    <tr class="table-danger">
                                @else
                                    <tr class="table-default">
                                @endif
                                <td>{{ $s->room->roomno }}/{{ $s->serial }}</td>
                                <td>
                                    @foreach($s->remarks as $rm)
                                        <li>{{ $rm->remark }}</li>
                                    @endforeach
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @else
                @if(count($non_rooms) > 0)
                    <table class="table table-hover table-auto">
                        <thead>
                            <tr>
                                <th>Room No.</th><th>Remarks</th><tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($non_rooms as $r)
                                @if($r->available == 0 || $r->capacity == 0)
                                    <tr class="table-danger">
                                @else
                                    <tr class="table-default">
                                @endif
                                <td>{{ $r->roomno }}</td>
                                <td>
                                    @foreach($r->remarks as $rm)
                                        <li>{{ $rm->remark }}</li>
                                    @endforeach
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if(count($non_seats) > 0)
                    <table class="table table-hover table-auto">
                        <thead>
                            <tr>
                                <th>Seat No.</th><th>Remarks</th><tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($non_seats as $s)
                                @if($s->available == 0 || $s->capacity == 0)
                                    <tr class="table-danger">
                                @else
                                    <tr class="table-default">
                                @endif
                                <td>{{ $s->room->roomno }}/{{ $s->serial }}</td>
                                <td>
                                    @foreach($s->remarks as $rm)
                                        <li>{{ $rm->remark }}</li>
                                    @endforeach
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </x-block>
    </x-container>
</x-layout>
