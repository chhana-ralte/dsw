<x-layout>
    <x-slot name="header">
        {{ $room->roomno }}
    </x-slot>
    <x-container>
        <x-block>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    @foreach($seats as $s)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/seat/{{ $s->id }}">{{ $s->serial }}</a></td>
                        @if( $s->allot_seat())
                            <td>{{ $s->allot_seat()->allot_hostel->person->name }}</td>
                            @if($s->allot_seat()->allot_hostel->person->student())
                                <td>{{ $s->allot_seat()->allot_hostel->person->student()->course }}</td>
                                <td>{{ $s->allot_seat()->allot_hostel->person->student()->department }}</td>
                                <td>{{ $s->allot_seat()->allot_hostel->person->student()->mzuid }}</td>
                            @endif
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
