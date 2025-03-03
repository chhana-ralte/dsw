<x-layout>
    <x-container>
        @if($allot_seats)
        <x-block>
            <x-slot name="heading">
                Residents of {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/occupants">Un-allotted seats in the hostel</a>
                </p>
            </x-slot>
            <table class="table table-hover table-auto">
                <thead>
                    <tr>
                        <th>Seat No.</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>MZU ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allot_seats as $as)
                        <tr class="table-white">
                        <td>{{ $as->seat->room->roomno }}/{{ $as->seat->serial }}</td>

                        <td><a href='/allot_hostel/{{ $as->allot_hostel->id }}'>{{ $as->allot_hostel->person->name }}</a></td>
                        @if($as->allot_hostel->person->student())
                            <td>{{ $as->allot_hostel->person->student()->course }}</td>
                            <td>{{ $as->allot_hostel->person->student()->department }}</td>
                            <td>{{ $as->allot_hostel->person->student()->mzuid }}</td>
                        @else
                            <td colspan=3>Not a student</td>
                        @endif
                        
                    </tr>
                    @endforeach
                    </tbody>
            </table>
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
            <table class="table table-hover table-auto">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>MZU ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($allot_hostels)>0)
                        @foreach($allot_hostels as $ah)
                            <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                <td><a href="/allot_hostel/{{ $ah->id }}">{{ $ah->person->name }}</a></td>
                                @if($ah->person->student())
                                    <td>{{ $ah->person->student()->course }}</td>
                                    <td>{{ $ah->person->student()->department }}</td>
                                    <td>{{ $ah->person->student()->mzuid }}</td>
                                @else
                                    <td colspan=3>Not a student</td>
                                @endif
                                <td><a class="btn btn-primary" href="/allot_hostel/{{ $ah->id }}/allotSeat">Allot seat</a></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </x-block>
        @endif
    </x-container>
</x-layout>
