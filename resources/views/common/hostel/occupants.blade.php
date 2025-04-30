<x-layout>
    <x-container>
        @if(isset($seats))
        <x-block>
            <x-slot name="heading">
                Residents of {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=0">Un-allotted seats in the hostel</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Seat No.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            @if(auth()->user()->max_role_level() >= 3)
                                <th>User?</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seats as $seat)
                            <tr class="table-white">
                            <td>{{ $seat->room->roomno }}/{{ $seat->serial }}</td>
                            @if($seat->valid_allot_seats()->count() > 0)
                                <td>
                                    @can('view',$seat->valid_allot_seat()->allot_hostel->allotment)
                                        <a href='/allotment/{{ $seat->valid_allot_seat()->allot_hostel->allotment->id }}'>{{ $seat->valid_allot_seat()->allot_hostel->allotment->person->name }}</a>
                                    @else
                                        {{ $seat->valid_allot_seat()->allot_hostel->allotment->person->name }} 
                                    @endcan
                                </td>
                                @if($seat->valid_allot_seat()->allot_hostel->allotment->person->student())
                                    <td>{{ $seat->valid_allot_seat()->allot_hostel->allotment->person->student()->course }}</td>
                                    <td>{{ $seat->valid_allot_seat()->allot_hostel->allotment->person->student()->department }}</td>
                                    <td>{{ $seat->valid_allot_seat()->allot_hostel->allotment->person->student()->mzuid }}</td>
                                    @if(auth()->user()->max_role_level() >= 3)
                                        <td>{{ $seat->valid_allot_seat()->allot_hostel->allotment->user()?'Yes':'No' }}</td>
                                    @endif
                                @elseif($seat->valid_allot_seat()->allot_hostel->allotment->person->other())
                                    <td colspan=3>Not a student ({{ $seat->valid_allot_seat()->allot_hostel->allotment->person->other()->remark }})</td>
                                @endif
                            @elseif($seat->available < 1)
                                <td colspan=4>Seat is unavailable for allotment</td>
                            @else
                                <td colspan=4>Seat is vacant</td>
                            @endif
                            
                        </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </x-block>

        @else

        <x-block>
            <x-slot name="heading">
                Residents of {{ $hostel->name }} Hall of Residence who are not allotted room/seat
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=1">Allotted seats in the hostel</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            @auth
                                @can('update',$hostel)
                                    <th>Action</th>
                                @endcan
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($allot_hostels)>0)
                            @foreach($allot_hostels as $ah)
                                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                    <td>
                                        @can('view',$ah->allotment)
                                            <a href="/allotment/{{ $ah->allotment->id }}">{{ $ah->allotment->person->name }}</a>
                                        @else
                                            {{ $ah->allotment->person->name }} 
                                        @endcan
                                    </td>
                                    @if($ah->allotment->person->student())
                                        <td>{{ $ah->allotment->person->student()->course }}</td>
                                        <td>{{ $ah->allotment->person->student()->department }}</td>
                                        <td>{{ $ah->allotment->person->student()->mzuid }}</td>
                                    @elseif($ah->allotment->person->other())
                                        <td colspan=3>Not a student ({{ $ah->allotment->person->other()->remark }})</td>
                                    @endif
                                    @auth
                                        @if(auth()->user()->isWardenOf($ah->hostel->id))
                                            <td><a class="btn btn-primary" href="/allot_hostel/{{ $ah->id }}/allotSeat">Allot seat</a></td>
                                        @endif
                                    @endauth
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </x-block>
        @endif
    </x-container>
</x-layout>
