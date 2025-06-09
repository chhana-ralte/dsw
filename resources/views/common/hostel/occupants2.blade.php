<x-layout>
    <x-container>
        @if(isset($seats))
        <x-block>
            <x-slot name="heading">
                Residents of {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=0">Un-allotted seats in the hostel</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Seat No.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            @if(auth()->user()->max_role_level() >= 3)
                                <th>User?</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($occupants as $occ)
                            <tr class="table-white">
                            <td>{{ $occ->roomno }}/{{ $occ->serial }}</td>
                            @if($occ->allotment_id)

                                <td>
                                    @can('view',$occ->allotment)
                                        <a href='/allotment/{{ $occ->allotment->id }}'>{{ $occ->name }}</a>
                                    @else
                                        {{ $occ->name }}
                                    @endcan
                                </td>
                                @if($occ->student_id)
                                    <td>{{ $occ->course }}</td>
                                    <td>{{ $occ->department }}</td>
                                    <td>{{ $occ->mzuid }}</td>
                                    @if(auth()->user()->max_role_level() >= 3)
                                        <td>{{ $occ->allotment->user()?'Yes':'No' }}</td>
                                    @endif
                                @elseif($occ->person->other())
                                    <td colspan=3>Not a student ({{ $occ->person->other()->remark }})</td>
                                @endif
                            @elseif($occ->available < 1)
                                <td colspan=4>Seat is unavailable for allotment</td>
                            @else
                                <td colspan=4>Seat is vacant</td>
                            @endif

                        </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </x-block>

        @else

        <x-block>
            <x-slot name="heading">
                Residents of {{ $hostel->name }} Hall of Residence who are not allotted room/seat
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=1">Allotted seats in the hostel</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            @auth
                                @can('update',$hostel)
                                    <th>Action</th>
                                @endcan
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($occupants)>0)
                            @foreach($occupants as $occ)
                                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                    <td>
                                        @can('view',$occ->allotment_id)
                                            <a href="/allotment/{{ $occ->allotment_id }}">{{ $occ->name }}</a>
                                        @else
                                            {{ $occ->allotment->person->name }}
                                        @endcan
                                    </td>
                                    @if($occ->student_id)
                                        <td>{{ $occ->course }}</td>
                                        <td>{{ $occ->department }}</td>
                                        <td>{{ $occ->mzuid }}</td>
                                    @elseif($occ->person->other())
                                        <td colspan=3>Not a student ({{ $occ->person->other()->remark }})</td>
                                    @endif
                                    @auth
                                        @if(auth()->user()->isWardenOf($hostel->id))
                                            <td><a class="btn btn-primary" href="/allot_hostel/{{ $occ->id }}/allotSeat">Allot seat</a></td>
                                        @endif
                                    @endauth
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </x-block>
        @endif
    </x-container>
</x-layout>
