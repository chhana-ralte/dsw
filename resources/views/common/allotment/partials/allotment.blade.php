<x-slot name="heading">
    Hostel allotment information
    @auth()
        @can('manage_self',$allotment)
            <a class="btn btn-secondary btn-sm"
                href="/allotment/{{ $allotment->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
        @endcan
    @endauth
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#financeModal"
                            data-bs-whatever="Remark">Brief info</button>
</x-slot>
<table class="table">
    <tr>
        <td>Initial hostel allotted</td>
        <td>{{ $allotment->hostel->name }}</td>
    </tr>
    <tr>
        <td>Notification</td>
        <td>{{ $allotment->notification->no }} dated {{ $allotment->notification->dt }}</td>
    </tr>
    <tr>
        <td>Tentative allotment duration</td>
        <td>{{ $allotment->from_dt }} to {{ $allotment->to_dt }}</td>
    </tr>

    <tr>
        <td>Starting session</td>
        <td>
            @if($allotment->start_sessn())
                {{ $allotment->start_sessn()->name() }}
            @else
                Not defined
            @endif
        </td>
    </tr>

    <tr>
        <td>Expected ending session</td>
        <td>
            @if($allotment->end_sessn())
                {{ $allotment->end_sessn()->name() }}
            @else
                Not defined
            @endif
        </td>
    </tr>

    <tr>
        <td>Admission confirmed</td>
        <td>{{ $allotment->confirmed ? 'Yes' : 'No' }}</td>
    </tr>

    <tr>
        <td>Admission done?</td>
        <td>{{ $allotment->admitted ? 'Yes' : 'No' }}</td>
    </tr>
    <tr>
        <td>Allotment still valid?</td>
        <td>{{ $allotment->valid ? 'Yes' : 'No' }}</td>
    </tr>
    <tr>
        <td>Finished course and left?</td>
        <td>{{ $allotment->finished ? 'Yes' : 'No' }}</td>
    </tr>

</table>
    {{-- Modal for finance printing --}}
    @if($allotment)
        <div class="modal fade" id="financeModal" tabindex="-1" aria-labelledby="financeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="financeModalLabel">Brief allotment information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div style="width: 100%; overflow-x:auto">
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $allotment->person->name }}</td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td>{{ $allotment->person->email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{ $allotment->person->mobile }}</td>
                                </tr>
                                @if($allotment->person->student())
                                    <tr>
                                        <th>Course</th>
                                        <td>{{ $allotment->person->student()->course }}</td>
                                    </tr>

                                    <tr>
                                        <th>MZU ID</th>
                                        <td>{{ $allotment->person->student()->mzuid }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Initial Hostel allotted</th>
                                    <td>{{ $allotment->hostel->name }}</td>
                                </tr>
                                @if($allotment->valid_allot_hostel())
                                    <tr>
                                        <th>Current Hostel</th>
                                        <td>{{ $allotment->valid_allot_hostel()->hostel->name }}</td>
                                    </tr>
                                    @if($allotment->valid_allot_hostel()->valid_allot_seat())
                                        <tr>
                                            <th>Room</th>
                                            <td>{{ $allotment->valid_allot_hostel()->valid_allot_seat()->seat->room->roomno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Room type</th>
                                            <td>{{ App\Models\Room::room_type($allotment->valid_allot_hostel()->valid_allot_seat()->seat->room->capacity) }}</td>
                                        </tr>
                                    @endif
                                @endif
                                
                                
                            </table>
                        </div>
                            {{-- <div class="mb-3">
                                <label for="hostel" class="col-form-label">Hostel</label>
                                
                            </div>
                            <div class="mb-3">
                                <label for="type" class="col-form-label">Room type:</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="1">Single</option>
                                    <option value="2" selected>Double</option>
                                    <option value="3">Triple</option>
                                    <option value="4">Dorm</option>
                                </select>
                            </div> --}}
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- End Modal for finance printing --}}