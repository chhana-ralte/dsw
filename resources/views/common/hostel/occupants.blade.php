<x-layout>
    <x-slot name="header">
        {{ $hostel->name }}
    </x-slot>
    <x-container>
        <x-block>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    @foreach($allot_seats as $as)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/hostel/{{ $hostel->id }}">{{ $as->allot_hostel->person->name }}</a></td>
                        @if($as->allot_hostel->person->student())
                            <td>{{ $as->allot_hostel->person->student()->course }}</td>
                            <td>{{ $as->allot_hostel->person->student()->department }}</td>
                            <td>{{ $as->allot_hostel->person->student()->mzuid }}</td>
                        @else
                            <td colspan=3>Not a student</td>
                        @endif
                    </tr>
                    @endforeach


                    @if(count($allot_hostels)>0)
                        <tr><td colspan="4">Room not allotted list</td></tr>
                        @foreach($allot_hostels as $ah)
                            <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td><a href="/hostel/{{ $hostel->id }}">{{ $ah->person->name }}</a></td>
                            @if($as->allot_hostel->person->student())
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
