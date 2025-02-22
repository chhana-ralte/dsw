<x-layout>
    <x-slot name="heading">
        {{ $hostel->name }}
    </x-slot>
    <x-container>
        <x-block>
            @if(count($rooms)>0)
                <table class="table table-hover table-auto table-striped">
                    <thead>
                        <tr>
                        <th>Hostel name</th><th>Gender</th><tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $r)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td><a href="/room/{{ $r->id }}">{{ $r->roomno }}</a></td>
                            <td>{{ $r->roomno }}</td>
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
