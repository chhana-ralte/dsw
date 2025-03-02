<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Residents of {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
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
                    @foreach($occupants as $oc)
                        <tr class="table-white">
                        <td>{{ $oc->roomno }}/{{ $oc->serial }}</td>
                       
                        <td><a href='/allot_hostel/{{ $oc->valid_allot_seat()->allot_hostel->id }}'>{{ $oc->valid_allot_seat()->allot_hostel->person->name }}</a></td>
                        @if($oc->valid_allot_seat()->allot_hostel->person->student())
                            <td>{{ $oc->valid_allot_seat()->allot_hostel->person->student()->course }}</td>
                            <td>{{ $oc->valid_allot_seat()->allot_hostel->person->student()->department }}</td>
                            <td>{{ $oc->valid_allot_seat()->allot_hostel->person->student()->mzuid }}</td>
                        @else
                            <td colspan=3>Not a student</td>
                        @endif
                        
                    </tr>
                    @endforeach


                    @if(count($allot_hostels)>0)
                        <tr><td colspan="4">Room not allotted list</td></tr>
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
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
