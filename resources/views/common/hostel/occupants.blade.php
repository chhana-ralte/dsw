<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ $hostel->name }}
            </x-slot>
            <table class="table table-hover table-auto">
                <tbody>
                    @foreach($seats as $s)
                        @if($s->allot_seat())
                            <tr class="table-white">
                        @else
                            <tr class="table-active">
                        @endif
                        <td><a href="/seat/{{ $s->id }}">{{ $s->room->roomno }}/{{ $s->serial }}</a></td>
                        @if($s->allot_seat())
                            <td><a href='/allot_hostel/{{ $s->allot_seat()->allot_hostel->id }}'>{{ $s->allot_seat()->allot_hostel->person->name }}</a></td>
                            @if($s->allot_seat()->allot_hostel->person->student())
                                <td>{{ $s->allot_seat()->allot_hostel->person->student()->course }}</td>
                                <td>{{ $s->allot_seat()->allot_hostel->person->student()->department }}</td>
                                <td>{{ $s->allot_seat()->allot_hostel->person->student()->mzuid }}</td>
                            @else
                                <td colspan=3>Not a student</td>
                            @endif
                        @else
                            <td>Seat vacant</td>
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
