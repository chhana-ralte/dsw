<x-layout>
    <x-slot name="header">
        {{ $hostel->name }}
    </x-slot>
    <x-container>
        <x-block>
            <a class="btn btn-primary btn-lg" href="/hostel/{{ $hostel->id }}/room">ROOMS</a>
            <a class="btn btn-primary btn-lg" href="/hostel/{{ $hostel->id }}/occupants">Occupants</a>
            <table class="table table-hover table-auto table-striped">
                <tbody>
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td><a href="/hostel/{{ $hostel->id }}">{{ $hostel->name }}</a></td>
                        <td>{{ $hostel->gender }}</td>
                    </tr>
                </tbody>
            </table>
        </x-block>
    </x-container>
</x-layout>
