<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Personal information
                @auth()
                    @can('update',$allotment->hostel) 
                        <a class="btn btn-secondary btn-sm" href="/person/{{ $allotment->person->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                    @endcan
                    <a class="btn btn-secondary btn-sm" href="/person/{{ $allotment->person->id }}/person_remark?back_link=/allotment/{{ $allotment->id }}">Remarks about the person</a>

                    @if(auth()->user()->isAdmin())
                        <a class="btn btn-danger btn-sm" href="/person/{{ $allotment->person->id }}/confirm_delete?back_link=/allotment/{{ $allotment->id }}">Delete</a>
                    @endif
                @endauth
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
            <table class="table table-hover table-auto">
                <tr>
                    <th>Name</th>
                    <td>{{ $allotment->person->name }}</td>
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
        </x-block>

        @if($allotment->person->student())
            <x-block>
                <x-slot name="heading">
                    Student Information
                    @auth()
                        @can('update',$allotment->hostel)
                            <a class="btn btn-secondary btn-sm" href="/student/{{ $allotment->person->student()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                        @endcan
                    @endauth
                </x-slot>                
                <table class="table table-hover table-auto">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>Rollno</td>
                        <td>{{ $allotment->person->student()->rollno }}</td>
                    </tr>
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>Course name</td>
                        <td>{{ $allotment->person->student()->course }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $allotment->person->student()->department }}</td>
                    </tr>
                    </tr>
                        <td>MZU ID</td>
                        <td>{{ $allotment->person->student()->mzuid }}</td>                    
                    </tr>
                </table>
            </x-block>
        @elseif($allotment->person->other())
            <x-block>
                <x-slot name="heading">
                    Other information
                </x-slot>                
                <table class="table table-hover table-auto table-striped">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $allotment->person->other()->remark }}</td>
                    </tr>
                </table>
            </x-block>
        @else
            @auth
                @can('update',$allotment->hostel)
                    <x-block>
                        <x-slot name="heading">
                            Whether a student or not??
                        </x-slot>
                        <div>
                            <a href="/person/{{ $allotment->person->id }}/student/create?back_link=/allotment/{{ $allotment->id }}" class="btn btn-primary">Add student information</a>
                            <a href="/person/{{ $allotment->person->id }}/other/create?back_link=/allotment/{{ $allotment->id }}" class="btn btn-primary">Not a student</a>
                        </div>
                    </x-block>
                @endcan
            @endauth
        @endif

        <x-block>
            <x-slot name="heading">
                Seat Allotment Information
            </x-slot>
            @if(count($allotment->allot_hostels) > 0)
                @foreach($allotment->allot_hostels as $ah)
                    <b>{{ $ah->hostel->name }}</b> ({{ $ah->valid?'Valid':'Invalid' }})<br>
                    @foreach($ah->allot_seats as $as)
                        {{ $as->seat->room->roomno }}/{{ $as->seat->serial }} ({{ $as->valid?'Valid':'Invalid' }})<br>
                    @endforeach
                    <hr>
                @endforeach
            @endif

            @auth
                @if($allotment->valid_allot_hostel())
                    @can('update',$allotment->valid_allot_hostel()->hostel)
                        <a class="btn btn-primary" href="/allot_hostel/{{ $allotment->valid_allot_hostel()->id }}/allotSeat">Change room/seat</a>
                    @endcan
                    @if(auth()->user()->isDSW())
                        <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot another hostel</a>
                    @endif
                @else
                @if(auth()->user()->isDSW())
                    <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot hostel</a>
                    @endif
                @endif
                
            @endauth
            
        </x-block>

        @if(count($allotment->person->person_remarks) > 0)
            <x-block>
                <x-slot name="heading">
                    Remark(s) about student
                </x-slot>                
                <table class="table table-hover table-auto">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <th>Date of incident</th>
                        <th>Remark</th>
                    </tr>
                    @foreach($allotment->person->person_remarks as $pr)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td>{{ $pr->remark_dt }}</td>
                            <td><h4>{{ $pr->remark }}</h4>
                            @if(count($pr->person_remark_details) > 0)
                                @foreach($pr->person_remark_details as $prd)
                                    <hr>
                                    {{ $prd->detail }}
                                @endforeach
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </x-block>
        @endif
    </x-container>
</x-layout>
