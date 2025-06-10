<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Requirement details {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to
                        {{ $hostel->name }}</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <thead>
                        <tr>
                            <th>Seat No.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
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
                            <td>{{ $occ->roomno }}/{{ $occ->serial }}</td>

                            <td>
                                @can('view', $occ->allotment)
                                    <a href='/allotment/{{ $occ->allotment->id }}'>{{ $occ->name }}</a>
                                @else
                                    {{ $occ->name }}
                                @endcan
                            </td>
                            @if ($occ->student_id)
                                <td>{{ $occ->course }}</td>
                                <td>{{ $occ->department }}</td>
                            @elseif($occ->person->other())
                                <td colspan=3>Not a student ({{ $occ->person->other()->remark }})</td>
                            @endif
                            @if ($occ->requirement())
                                <td>
                                    Hostel:{{ $occ->requirement()->hostel->name }}<br>
                                    Type:{{ $occ->requirement()->roomtype() }}<br>
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
