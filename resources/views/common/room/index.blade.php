<x-layout>
    <x-slot name="heading">
        {{ $hostel->name }}
    </x-slot>
    <x-container>
        <x-block>
            @if(count($rooms)>0)
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                        <th>Room No</th><th>Capacity</th><th>Available</th><tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $r)
                            @if($r->capacity == $r->available)
                                <tr class="table-default">
                            @else
                                <tr class="table-danger">
                            @endif

                            <td><a href="/room/{{ $r->id }}">{{ $r->roomno }}</a></td>
                            <td>{{ $r->capacity }}</td>
                            <td>{{ $r->available }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                No Hostel available
            @endif
        </x-block>
    </x-container>
</x-layout>
