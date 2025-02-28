<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seats in {{ $room->roomno }} of {{ $room->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}">back</a>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/seat/create">Create new seat</a>
                </p>
            </x-slot>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    <tr><th>Seat No.</th><th>Available?</th><th>Vacant?</th></tr>
                    @foreach($seats as $s)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/seat/{{ $s->id }}">{{ $room->roomno }}/{{ $s->serial }}</a></td>
                        <td>{{ $s->available ? 'Yes':'No' }}</td>
                        <td>{{ $s->vacant() ?'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
