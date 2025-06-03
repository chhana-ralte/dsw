<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Generation of Rooms for the hostels in the database
            </x-slot>
            <div style="width: 100%, overflow-x: auto;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Roomno</th>
                            <th>serial</th>
                            <th>Name</th>
                            <th>Hostel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($occupants as $occ)
                            <tr>
                                <td>{{ $occ->roomno }}</td>
                                <td>{{ $occ->serial }}</td>
                                <td>{{ $occ->name }}</td>
                                <td>{{ $occ->allot_hostel->valid }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>
    </x-container>
</x-layout>
