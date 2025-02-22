<x-layout>
    <x-slot name="header">
        {{ __('Hostels') }}
    </x-slot>
    <x-container>
        <x-block>
            @if(count($hostels)>0)
                <table class="table table-hover table-auto table-striped">
                    <thead>
                        <tr>
                        <th>Hostel name</th><th>Gender</th><tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hostels as $h)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td><a href="/hostel/{{ $h->id }}">{{ $h->name }}</a></td>
                            <td>{{ $h->gender }}</td>
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
