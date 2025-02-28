<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Rooms in {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">back</a>
                </p>
            </x-slot>
            @if(count($rooms)>0)
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                        <th>Room No</th><th>Capacity</th><th>Available</th><th>Manage</th><th>Remarks</th><tr>
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
                No Hostel available
            @endif
        </x-block>
    </x-container>
</x-layout>
