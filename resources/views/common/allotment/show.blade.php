<x-layout>

    <x-container>
        <x-block>
            <x-slot name="heading">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full md:w-auto">
                        Personal information
                    </div>
                    <div class="w-full md:w-auto flex flex-wrap gap-2 mt-2 md:mt-0">
                        @auth()
                            @can('edit', $allotment->person)
                                <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                    href="/person/{{ $allotment->person->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                            @endcan

                            <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                href="/person/{{ $allotment->person->id }}/person_remark?back_link=/allotment/{{ $allotment->id }}">Remarks
                                about the person</a>

                            @if (auth()->user()->isAdmin())
                                <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm"
                                    href="/person/{{ $allotment->person->id }}/confirm_delete?back_link=/allotment/{{ $allotment->id }}">Delete
                                </a>
                            @endif
                        @endauth
                        <p class="mt-2 md:mt-0">
                            @auth
                                @if (auth()->user()->isAdmin())
                                    <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                        href="/notification/{{ $allotment->notification->id }}/allotment">Back to
                                        allotments</a>
                                @endif

                                @if ($allotment->valid_allot_hostel())
                                    <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                        href="/hostel/{{ $allotment->valid_allot_hostel()->hostel->id }}/occupants">Back to
                                        occupants</a>
                                @else
                                    <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                        href="/hostel/{{ $allotment->hostel->id }}/occupants">Back
                                        to occupants</a>
                                @endif
                            @endauth
                        </p>
                    </div>
                </div>

            </x-slot>

            @if ($allotment->cancel_seat)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold text-center">The inmate is no longer in the hostel</strong>
                </div>
            @endif

            <table class="min-w-full table-auto bg-white text-black">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <td class="px-4 py-2">{{ $allotment->person->name }}</td>
                    <td rowspan=7 class="px-4 py-2"><img width="200px" src="{{ $allotment->person->photo }}"
                            alt="" srcset=""></td>
                </tr>
                <tr>
                    <th class="px-4 py-2">Father/Guardian's name</th>
                    <td class="px-4 py-2">{{ $allotment->person->father }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2">Mobile</th>
                    <td class="px-4 py-2">{{ $allotment->person->mobile }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2">Email</th>
                    <td class="px-4 py-2">{{ $allotment->person->email }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2">Category</th>
                    <td class="px-4 py-2">{{ $allotment->person->category }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2">State/UT</th>
                    <td class="px-4 py-2">{{ $allotment->person->state }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2">Address</th>
                    <td class="px-4 py-2">{{ $allotment->person->address }}</td>
                </tr>
            </table>
        </x-block>

        @if ($allotment->person->student())
            <x-block>
                <x-slot name="heading">
                    Student Information
                    <div class="float-right space-x-2">
                        @auth()
                            @can('edit', $allotment->person)
                                <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                    href="/student/{{ $allotment->person->student()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                            @endcan
                            @if (auth()->user()->isAdmin())
                                <button form="frm_delete"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">Delete
                                    student info
                                </button>
                                <form id="frm_delete" method="post"
                                    action="/student/{{ $allotment->person->student()->id }}"
                                    onsubmit="return confirm('Are you sure you want to delete student information of this person?')">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="back_link" value="/allotment/{{ $allotment->id }}">
                                </form>
                            @endif
                        @endauth
                    </div>
                </x-slot>
                <table class="min-w-full table-auto bg-white text-black">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td class="px-4 py-2">Rollno</td>
                        <td class="px-4 py-2">{{ $allotment->person->student()->rollno }}</td>
                    </tr>
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td class="px-4 py-2">Course name</td>
                        <td class="px-4 py-2">{{ $allotment->person->student()->course }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Department</td>
                        <td class="px-4 py-2">{{ $allotment->person->student()->department }}</td>
                    </tr>
                    </tr>
                    <td class="px-4 py-2">MZU ID</td>
                    <td class="px-4 py-2">{{ $allotment->person->student()->mzuid }}</td>
                    </tr>
                </table>
            </x-block>
        @elseif($allotment->person->other())
            <x-block>
                <x-slot name="heading">
                    Other informations
                    <div class="float-right space-x-2">
                        @auth()
                            @can('update', $current_hostel)
                                <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                                    href="/other/{{ $allotment->person->other()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                            @endcan
                            @if (auth()->user()->isAdmin())
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm"
                                    form="frm_delete">Delete other info
                                </button>
                                <form id="frm_delete" method="post" action="/other/{{ $allotment->person->other()->id }}"
                                    onsubmit="return confirm('Are you sure you want to delete other information of this person?')">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="back_link" value="/allotment/{{ $allotment->id }}">
                                </form>
                            @endif
                        @endauth
                    </div>
                </x-slot>
                <table class="min-w-full table-auto table-striped bg-white text-black">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td class="px-4 py-2">{{ $allotment->person->other()->remark }}</td>
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
                        <div class="flex space-x-4">
                            <a href="/person/{{ $allotment->person->id }}/student/create?back_link=/allotment/{{ $allotment->id }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add student
                                information</a>
                            <a href="/person/{{ $allotment->person->id }}/other/create?back_link=/allotment/{{ $allotment->id }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Not a student</a>
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
                        <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                            href="/allotment/{{ $allotment->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
                    @endif
                @endauth
            </x-slot>
            <table class="min-w-full bg-white text-black">
                <tr>
                    <td class="px-4 py-2">Initial hostel allotted</td>
                    <td class="px-4 py-2">{{ $allotment->hostel->name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Notification</td>
                    <td class="px-4 py-2">{{ $allotment->notification->no }} dated {{ $allotment->notification->dt }}
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Tentative allotment duration</td>
                    <td class="px-4 py-2">{{ $allotment->from_dt }} to {{ $allotment->to_dt }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Admission done?</td>
                    <td class="px-4 py-2">{{ $allotment->admitted ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Allotment still valid?</td>
                    <td class="px-4 py-2">{{ $allotment->valid ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">Finished course and left?</td>
                    <td class="px-4 py-2">{{ $allotment->finished ? 'Yes' : 'No' }}</td>
                </tr>

            </table>
        </x-block>


        <x-block>
            <x-slot name="heading">
                Seat Allotment Information
            </x-slot>
            @if (count($allotment->allot_hostels) > 0)
                @foreach ($allotment->allot_hostels as $ah)
                    <div class="mb-4">
                        <b class="font-bold">{{ $ah->hostel->name }}</b> ({{ $ah->valid ? 'Valid' : 'Invalid' }})<br>
                        @foreach ($ah->allot_seats as $as)
                            <span class="ml-4">{{ $as->seat->room->roomno }}/{{ $as->seat->serial }}
                                ({{ $as->valid ? 'Valid' : 'Invalid' }})
                            </span>
                            <br>
                        @endforeach
                        <hr class="my-2">
                    </div>
                @endforeach
            @endif

            @auth
                @if ($allotment->valid_allot_hostel())
                    @can('edit', $allotment)
                        <div class="space-x-2">
                            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                href="/allot_hostel/{{ $allotment->valid_allot_hostel()->id }}/allotSeat">Change room/seat</a>
                            <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                href="/allotment/{{ $allotment->id }}/cancelSeat/create">Cancel the seat</a>
                        </div>
                    @endcan
                    @if (auth()->user()->isDsw())
                        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot another
                            hostel</a>
                    @endif
                @else
                    @if (auth()->user()->isDsw())
                        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot
                            hostel</a>
                    @endif
                @endif

                @if (auth()->user()->isAdmin())
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        form="clear_allotment">Clear allotment info</button>
                    <form id="clear_allotment" type="hidden" method="post"
                        action="/allotment/{{ $allotment->id }}/clear_allotment"
                        onsubmit="return confirm('Are you sure you want to clear all allotment details?')">
                        @csrf
                    </form>
                @endif
            @endauth

        </x-block>

        @can('manage', $allotment)
            <x-block>
                <x-slot name="heading">
                    User information about the student
                </x-slot>
                @if ($allotment->user())
                    <table class="min-w-full">
                        <tr>
                            <td class="px-4 py-2">Username</td>
                            <td class="px-4 py-2">{{ $allotment->user()->username }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="px-4 py-2">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Reset
                                    password</button>
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
                <table class="min-w-full">
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Last hostel from where cancelled</td>
                        <td class="px-4 py-2">{{ $allotment->cancel_seat->allot_hostel->hostel->name }}</td>
                    </tr>
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Last hostel room</td>
                        <td class="px-4 py-2">{{ $allotment->cancel_seat->allot_seat->seat->room->roomno }}</td>
                    </tr>
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Date of actual leaving/tentative leaving date</td>
                        <td class="px-4 py-2">{{ $allotment->cancel_seat->leave_dt }}</td>
                    </tr>
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Date of issuance</td>
                        <td class="px-4 py-2">{{ $allotment->cancel_seat->issue_dt }}</td>
                    </tr>
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Whether clearance can be given?</td>
                        <td class="px-4 py-2">{{ $allotment->cancel_seat->cleared ? 'Yes' : 'No' }}</td>
                    </tr>
                    @if ($allotment->cancel_seat->cleared == 0)
                        <tr class="px-4 py-2">
                            <td class="px-4 py-2">Amount due</td>
                            <td class="px-4 py-2">{{ $allotment->cancel_seat->outstanding }}</td>
                        </tr>
                    @endif
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Whether approved by DSW?</td>
                        <td class="px-4 py-2">{{ $allotment->valid ? 'Not yet' : 'Yes' }}</td>
                    </tr>
                    <tr class="px-4 py-2">
                        <td class="px-4 py-2">Whether course completed?</td>
                        <td class="px-4 py-2">{{ $allotment->cancel_seat->finished ? 'Yes' : 'No' }}</td>
                    </tr>
                </table>
            </x-block>
        @endif

        @if (count($allotment->person->person_remarks) > 0)
            <x-block>
                <x-slot name="heading">
                    Remark(s) about student
                </x-slot>
                <table class="min-w-full table-auto">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <th class="px-4 py-2">Date of incident</th>
                        <th class="px-4 py-2">Remark</th>
                    </tr>
                    @foreach ($allotment->person->person_remarks as $pr)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td class="px-4 py-2">{{ $pr->remark_dt }}</td>
                            <td class="px-4 py-2">
                                <h4 class="font-semibold">{{ $pr->remark }}</h4>
                                @if (count($pr->person_remark_details) > 0)
                                    @foreach ($pr->person_remark_details as $prd)
                                        <hr class="my-2">
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
