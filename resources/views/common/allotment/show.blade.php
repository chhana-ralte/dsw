<x-layout>
    <x-container>
        <x-block>
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
        </x-block>

        @if ($allotment->person->student())
            <x-block>
                <x-slot name="heading">
                    Student Information
                    @auth()
                        @can('edit', $allotment->person)
                            <a class="btn btn-secondary btn-sm"
                                href="/student/{{ $allotment->person->student()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                        @endcan
                        @if (auth()->user()->isAdmin())
                            <button form="frm_delete" class="btn btn-danger btn-sm">Delete student info</a>
                                <form id="frm_delete" method="post"
                                    action="/student/{{ $allotment->person->student()->id }}"
                                    onsubmit="return confirm('Are you sure you want to delete student information of this person?')">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="back_link" value="/allotment/{{ $allotment->id }}">
                                </form>
                        @endif
                    @endauth
                </x-slot>
                <table class="table table-auto">
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
                    Other informations
                    @auth()
                        @can('update', $current_hostel)
                            <a class="btn btn-secondary btn-sm"
                                href="/other/{{ $allotment->person->other()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                        @endcan
                        @if (auth()->user()->isAdmin())
                            <button type="submit" class="btn btn-danger btn-sm" form="frm_delete">Delete other info</a>
                                <form id="frm_delete" method="post" action="/other/{{ $allotment->person->other()->id }}"
                                    onsubmit="return confirm('Are you sure you want to delete other information of this person?')">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="back_link" value="/allotment/{{ $allotment->id }}">
                                </form>
                        @endif
                    @endauth
                </x-slot>
                <table class="table table-auto table-striped">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $allotment->person->other()->remark }}</td>
                    </tr>
                </table>
            </x-block>
        @else
            @auth
                @can('edit', $allotment)
                    <x-block>
                        <x-slot name="heading">
                            Whether a student or not??
                        </x-slot>
                        <div>
                            <a href="/person/{{ $allotment->person->id }}/student/create?back_link=/allotment/{{ $allotment->id }}"
                                class="btn btn-primary">Add student information</a>
                            <a href="/person/{{ $allotment->person->id }}/other/create?back_link=/allotment/{{ $allotment->id }}"
                                class="btn btn-primary">Not a student</a>
                        </div>
                    </x-block>
                @endcan
            @endauth
        @endif



        <x-block>
            <x-slot name="heading">
                Hostel allotment information
                @auth()
                    @if (auth()->user()->isAdmin())
                        <a class="btn btn-secondary btn-sm"
                            href="/allotment/{{ $allotment->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                    @endif
                @endauth
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
        </x-block>


        <x-block>
            <x-slot name="heading">
                Seat Allotment Information
            </x-slot>
            @if (count($allotment->allot_hostels) > 0)
                @foreach ($allotment->allot_hostels as $ah)
                    <b>{{ $ah->hostel->name }}</b> ({{ $ah->valid ? 'Valid' : 'Invalid' }})<br>
                    @foreach ($ah->allot_seats as $as)
                        {{ $as->seat->room->roomno }}/{{ $as->seat->serial }}
                        ({{ $as->valid ? 'Valid' : 'Invalid' }})
                        <br>
                    @endforeach
                    <hr>
                @endforeach
            @endif

            @auth
                @if ($allotment->valid_allot_hostel())
                    @can('edit', $allotment)
                        <a class="btn btn-primary"
                            href="/allot_hostel/{{ $allotment->valid_allot_hostel()->id }}/allotSeat">Change room/seat</a>
                        <a class="btn btn-danger" href="/allotment/{{ $allotment->id }}/cancelSeat/create">Cancel the seat</a>
                    @endcan
                    @if (auth()->user()->isDsw())
                        <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot another
                            hostel</a>
                    @endif
                @else
                    @if (auth()->user()->isDsw())
                        <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot
                            hostel</a>
                    @endif
                @endif

                @if (auth()->user()->isAdmin())
                    <button class="btn btn-danger" form="clear_allotment">Clear allotment info</button>
                    <form id="clear_allotment" type="hidden" method="post"
                        action="/allotment/{{ $allotment->id }}/clear_allotment"
                        onsubmit="return confirm('Are you sure you want to clear all allotment details?')">
                        @csrf
                    </form>
                @endif
            @endauth

        </x-block>

        @can('manage',$allotment)
            <x-block>
                <x-slot name="heading">
                    User information about the student
                </x-slot>
                @if($allotment->user())
                    <table class="table">
                        <tr>
                            <td>Username</td>
                            <td>{{ $allotment->user()->username }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-primary" href="/user/{{ $allotment->user()->id }}/changePassword">Reset password</a>
                            </td>
                        </tr>
                    </table>
                @else
                    User not available
                @endif
            </x-block>
        @endcan

        @if ($allotment->cancel_seat)
            <x-block>
                <x-slot name="heading">
                    Seat cancelled...
                </x-slot>
                <table class="table">
                    <tr>
                        <td>Last hostel from where cancelled</td>
                        <td>{{ $allotment->cancel_seat->allot_hostel->hostel->name }}</td>
                    </tr>
                    <tr>
                        <td>Last hostel room</td>
                        <td>{{ $allotment->cancel_seat->allot_seat->seat->room->roomno }}</td>
                    </tr>
                    <tr>
                        <td>Date of actual leaving/tentative leaving date</td>
                        <td>{{ $allotment->cancel_seat->leave_dt }}</td>
                    </tr>
                    <tr>
                        <td>Date of issuance</td>
                        <td>{{ $allotment->cancel_seat->issue_dt }}</td>
                    </tr>
                    <tr>
                        <td>Whether clearance can be given?</td>
                        <td>{{ $allotment->cancel_seat->cleared ? 'Yes' : 'No' }}</td>
                    </tr>
                    @if ($allotment->cancel_seat->cleared == 0)
                        <tr>
                            <td>Amount due</td>
                            <td>{{ $allotment->cancel_seat->outstanding }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Whether approved by DSW?</td>
                        <td>{{ $allotment->valid ? 'Not yet' : 'Yes' }}</td>
                    </tr>
                    <tr>
                        <td>Whether course completed?</td>
                        <td>{{ $allotment->cancel_seat->finished ? 'Yes' : 'No' }}</td>
                    </tr>
                </table>
            </x-block>
        @endif

        @if (count($allotment->person->person_remarks) > 0)
            <x-block>
                <x-slot name="heading">
                    Remark(s) about student
                </x-slot>
                <table class="table table-auto">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <th>Date of incident</th>
                        <th>Remark</th>
                    </tr>
                    @foreach ($allotment->person->person_remarks as $pr)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td>{{ $pr->remark_dt }}</td>
                            <td>
                                <h4>{{ $pr->remark }}</h4>
                                @if (count($pr->person_remark_details) > 0)
                                    @foreach ($pr->person_remark_details as $prd)
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
