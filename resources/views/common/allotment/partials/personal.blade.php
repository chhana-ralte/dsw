<x-slot name="heading">
    <div class="row ">
        <div class="col">
            Personal information
            @auth()
                @can('edit',$allotment->person)
                    <a class="btn btn-secondary btn-sm"
                        href="/person/{{ $allotment->person->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                @endcan

                @can('manage',$allotment)
                    <a class="btn btn-secondary btn-sm"
                        href="/person/{{ $allotment->person->id }}/person_remark?back_link=/allotment/{{ $allotment->id }}">Remarks
                        about the person</a>
                @endcan

                @if (auth()->user()->isAdmin())
                    <a class="btn btn-danger btn-sm"
                        href="/person/{{ $allotment->person->id }}/confirm_delete?back_link=/allotment/{{ $allotment->id }}">Delete
                    </a>
                @endif

            @endauth
            <p>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a class="btn btn-secondary btn-sm"
                            href="/notification/{{ $allotment->notification->id }}/allotment">Back to
                            allotments</a>
                    @endif

                    @if (auth()->user()->max_role_level() >= 2 && $allotment->valid_allot_hostel())
                        @if($allotment->valid_allot_hostel())
                            <a class="btn btn-secondary btn-sm"
                                href="/hostel/{{ $allotment->valid_allot_hostel()->hostel->id }}/occupants">Back to
                                occupants</a>
                        @else
                            <a class="btn btn-secondary btn-sm"
                                href="/hostel/{{ $allotment->hostel->id }}/occupants">Back
                                to occupants</a>
                        @endif
                    @endif
                @endauth
            </p>
        </div>
    </div>
</x-slot>

@if ($allotment->cancel_seat)
    <div class="alert alert-danger">
        <strong align="center">The inmate is no longer in the hostel</strong>
    </div>
@endif

<table class="table table-auto">
    <tr>
        <th>Name</th>
        <td>{{ $allotment->person->name }}</td>
        <td rowspan=7><img width="200px" src="{{ $allotment->person->photo }}" alt="" srcset=""></td>
    </tr>
    <tr>
        <th>Father/Guardian's name</th>
        <td>{{ $allotment->person->father }}</td>
    </tr>
    <tr>
        <th>Mobile</th>
        <td>{{ $allotment->person->mobile }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $allotment->person->email }}</td>
    </tr>
    <tr>
        <th>Category</th>
        <td>{{ $allotment->person->category }}</td>
    </tr>
    <tr>
        <th>State/UT</th>
        <td>{{ $allotment->person->state }}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{ $allotment->person->address }}</td>
    </tr>
</table>
