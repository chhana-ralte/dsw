<x-layout>
    <x-slot name="header">
        {{ $room->roomno }}
    </x-slot>
    <x-container>
        <x-block>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    <tr><th>Seat No.</th><th>Available?</th><th>Vacant?</th></tr>
                    @foreach($seats as $s)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/seat/{{ $s->id }}">{{ $room->roomno }}/{{ $s->serial }}</a></td>
                        <td>{{ $s->available ? 'Yes':'No' }}</td>
                        <td>{{ $s->allot_seat() ?'No' : 'Yes' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
