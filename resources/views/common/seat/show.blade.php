<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seat {{ $seat->serial }} in room: {{ $seat->room->roomno }}
            </x-slot>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    <tr><th>Seat No.</th><th>Available?</th><th>Vacant?</th></tr>
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $seat->available ? 'Yes':'No' }}</td>
                        <td>{{ $seat->allot_seat() ?'No' : 'Yes' }}</td>
                    </tr>
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
