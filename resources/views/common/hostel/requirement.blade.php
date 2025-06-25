<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Requirement details {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to
                        {{ $hostel->name }}</a>
                </p>
                @can('manages',App\Models\Requirement::class)
                    <p>
                        <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/requirement_list">Manage/Approve</a>
                        <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/requirement_notify">Notify</a>
                    </p>
                @endcan
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <thead>
                        <tr>
                            <th>Seat No.</th>
                            <th>Student</th>
                            <th>Current</th>
                            <th>Requirement</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($occupants as $occ)
                            @if ($occ->requirement())
                                <tr class="table-light">
                                @else
                                <tr class="table-white">
                            @endif
                            <td>
                                @if($occ->roomno)
                                    {{ $occ->roomno }}/{{ $occ->serial }}
                                @else
                                    No seat allotted
                                @endif
                            </td>

                            <td>
                                @can('view', $occ->allotment)
                                    <a href='/allotment/{{ $occ->allotment->id }}'>{{ $occ->name }}</a>
                                @else
                                    {{ $occ->name }}
                                @endcan
                                @if ($occ->student_id)
                                    ({{ $occ->department }}: {{ $occ->course }})
                                @elseif($occ->person && $occ->person->other())
                                    Not a student ({{ $occ->person->other()->remark }})
                                @else
                                    ( No Info about the person )
                                @endif
                            </td>
                            <td>
                                Hostel: {{ $occ->allot_hostel->hostel->name }}<br>
                                Type: {{ $occ->allot_seat_id ? $occ->allot_seat->seat->room->type():'Undefined' }}
                            </td>
                            @if ($occ->requirement())
                                <td>
                                    Hostel: {{ $occ->requirement()->hostel->name }}<br>
                                    Type: {{ $occ->requirement()->roomtype() }}
                                </td>
                            @else
                                <td><span class="text-warning">No requirement submitted</span></td>
                            @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>

    </x-container>
</x-layout>
