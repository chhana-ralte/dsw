<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Personal information
                @auth()
                    @if(auth()->user()->isWardenOf($allot_hostel->hostel->id))
                        <a class="btn btn-secondary btn-sm" href="/person/{{ $allot_hostel->person->id }}/edit?back_link=/allot_hostel/{{ $allot_hostel->id }}">Edit</a>
                    @endif
                @endauth
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
            <table class="table table-hover table-auto">
                <tr>
                    <th>Name</th>
                    <td>{{ $allot_hostel->person->name }}</td>
                </tr>
                <tr>
                    <th>Father/Guardian's name</th>
                    <td>{{ $allot_hostel->person->father }}</td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>{{ $allot_hostel->person->mobile }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $allot_hostel->person->email }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $allot_hostel->person->category }}</td>
                </tr>
                <tr>
                    <th>State/UT</th>
                    <td>{{ $allot_hostel->person->state }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $allot_hostel->person->address }}</td>
                </tr>
            </table>
        </x-block>

        @if($allot_hostel->person->student())
            <x-block>
                <x-slot name="heading">
                    Student Information
                    @auth()
                        @can('update',$allot_hostel->hostel)
                            <a class="btn btn-secondary btn-sm" href="/student/{{ $allot_hostel->person->student()->id }}/edit?back_link=/allot_hostel/{{ $allot_hostel->id }}">Edit</a>
                        @endcan
                    @endauth
                </x-slot>                
                <table class="table table-hover table-auto">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>Rollno</td>
                        <td>{{ $allot_hostel->person->student()->rollno }}</td>
                    </tr>
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>Course name</td>
                        <td>{{ $allot_hostel->person->student()->course }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $allot_hostel->person->student()->department }}</td>
                    </tr>
                    </tr>
                        <td>MZU ID</td>
                        <td>{{ $allot_hostel->person->student()->mzuid }}</td>                    
                    </tr>
                </table>
            </x-block>
        @elseif($allot_hostel->person->other())
            <x-block>
                <x-slot name="heading">
                    Other information
                </x-slot>                
                <table class="table table-hover table-auto table-striped">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $allot_hostel->person->other()->remark }}</td>
                    </tr>
                </table>
            </x-block>
        @else
            @auth
                @can('update',$allot_hostel->hostel)
                    <x-block>
                        <x-slot name="heading">
                            Whether a student or not??
                        </x-slot>
                        <div>
                            <a href="/person/{{ $allot_hostel->person->id }}/student/create?back_link=/allot_hostel/{{ $allot_hostel->id }}" class="btn btn-primary">Add student information</a>
                            <a href="/person/{{ $allot_hostel->person->id }}/other/create?back_link=/allot_hostel/{{ $allot_hostel->id }}" class="btn btn-primary">Not a student</a>
                        </div>
                    </x-block>
                @endcan
            @endauth
        @endif

        <x-block>
            <x-slot name="heading">
                Seat Allotment Information
            </x-slot>
            @if(count($allot_hostel->allot_seats)>0)
                @foreach($allot_hostel->allot_seats as $as)
                    {{ $as->seat->room->hostel->name }}: {{ $as->seat->room->roomno }}/{{ $as->seat->serial }} ({{ $as->valid?'Valid':'Invalid' }})<br>
                @endforeach
                @auth
                    @can('update',$allot_hostel->hostel)
                        <a class="btn btn-primary" href="/allot_hostel/{{ $allot_hostel->id }}/allotSeat">Allot another seat</a>
                    @endcan
                @endauth
            @else
                @auth
                    @can('update',$allot_hostel->hostel)
                        <a class="btn btn-primary" href="/allot_hostel/{{ $allot_hostel->id }}/allotSeat">Allot seat</a>
                    @endif
                @endauth
            @endif
        </x-block>
    </x-container>
</x-layout>
