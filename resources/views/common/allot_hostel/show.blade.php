<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Personal information
            </x-slot>
            <table class="table table-hover table-auto">
                <tr>
                    <th>Name</th>
                </tr>
                <tr>
                    <td>{{ $allot_hostel->person->name }}</td>
                </tr>
            </table>
        </x-block>

        @if($allot_hostel->person->student())
            <x-block>
                <x-slot name="heading">
                    Student Information
                </x-slot>                
                <table class="table table-hover table-auto table-striped">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $allot_hostel->person->student()->course }}</td>
                        <td>{{ $allot_hostel->person->student()->department }}</td>
                        <td>{{ $allot_hostel->person->student()->mzuid }}</td>                    
                    </tr>
                </table>
            </x-block>
        @endif
        <x-block>
            <x-slot name="heading">
                Seat Allotment Information
            </x-slot>
            @if(count($allot_hostel->allot_seats)>0)
                    @foreach($allot_hostel->allot_seats as $as)
                        {{ $as->seat->room->roomno }} <br>
                    @endforeach
            @else
                <a class="btn btn-primary" href="/allot_hostel/{{ $allot_hostel->id }}/allotSeat">Allot Seat</a>
            @endif
        </x-block>
    </x-container>
</x-layout>
