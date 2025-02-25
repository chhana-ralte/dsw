<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ $room->roomno }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $room->hostel->id }}">back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Current occupants
            </x-slot>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    @foreach($seats as $s)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/seat/{{ $s->id }}">{{ $s->serial }}</a></td>
                        @if( count($s->active_allot_seats()))
                            @foreach($s->active_allot_seats() as $as)
                                <td>{{ $as->allot_hostel->person->name }}</td>
                                @if($as->allot_hostel->person->student())
                                    <td>{{ $as->allot_hostel->person->student()->course }}</td>
                                    <td>{{ $as->allot_hostel->person->student()->department }}</td>
                                    <td>{{ $as->allot_hostel->person->student()->mzuid }}</td>
                                @endif
                            @endforeach
                        @else
                            <td colspan="4">Seat Vacant</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
