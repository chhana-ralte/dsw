<x-layout>
    <x-container>




        {{--
            <x-block>
            <x-slot name="heading">
                Menu
            </x-slot>

            <section id="Menu">
                <div class="container">
                    <div class="mb-4 row">
                        <a class="col-sm-3 bg-primary" href="/hostel/{{ $hostel->id }}/room">
                            <div class="mx-auto col col-md-4 bg-primary">
                                <span class="btn btn-primary">
                                    <h4>Rooms</h4>
                                </span>
                            </div>
                        </a>
                        <a class="col-sm-3 bg-secondary" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=1">
                            <div class="mx-auto col col-md-4">
                                <span class="btn btn-secondary">
                                    <h4>Occupants</h4>
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="mb-4 row">
                        <a class="col-sm-3 bg-primary" href="/hostel/{{ $hostel->id }}/room?status=vacant">
                            <div class="mx-auto col col-md-4 bg-primary">
                                <span class="btn btn-primary">
                                    <h4>Vacant Rooms</h4>
                                </span>
                            </div>
                        </a>
                        <a class="col-sm-3 bg-secondary" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=0">
                            <div class="mx-auto col col-md-4">
                                <span class="btn btn-secondary">
                                    <h4>Students having no room</h4>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </x-block>
        --}}




        <x-block>
            <x-slot name="heading">
                {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-primary btn-sm"
                        href="/hostel/{{ $hostel->id }}/admission?sessn={{ App\Models\Sessn::default()->id }}">Admission
                        details</a>
                    @auth
                        @if (auth()->user()->isDSW())
                            <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/warden">Manage Wardens</a>
                        @endif
                    @endauth
                </p>
            </x-slot>
            Summary
            <table class="table table-hover table-striped">
                <tbody>
                    <tr>
                        <td>Total number of rooms</td>
                        <td>{{ $no_rooms }}</td>
                        <td>
                            @auth
                                <a href="/hostel/{{ $hostel->id }}/room" type="button" class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td>Total number of seats</td>
                        <td>{{ $no_seats }}</td>
                        <td>

                        </td>
                    </tr>
                    <td>Total seats available for allotment</td>
                    <td>{{ $no_available_seats }}</td>
                    <td>

                    </td>
                    </tr>
                    <tr>
                        <td>Total number of students allotted</td>
                        <td>{{ $no_allotted_seats }}</td>

                        <td>
                            @auth
                                <a href="/hostel/{{ $hostel->id }}/occupants" type="button"
                                    class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>

                    </tr>
                    <tr>
                        <td>Total number of seats vacant</td>
                        <td>{{ $no_vacant_seats }}</td>

                        <td>
                            @auth
                                <a href="/hostel/{{ $hostel->id }}/room?status=vacant" type="button"
                                    class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>

                    </tr>
                    <tr>
                        <td>No. of students who are not allotted seat/room</td>
                        <td>{{ $no_unallotted }}</td>
                        <td>
                            @auth
                                <a href="/hostel/{{ $hostel->id }}/occupants?allot_seats=0" type="button"
                                    class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>
                    </tr>

                    <tr>
                        <td>Students who are newly allotted to this hostel</td>
                        <td>{{ $no_new_allotted }}</td>
                        <td>
                            @auth
                                <a href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}&adm_type=new"
                                    type="button" class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>
                    </tr>

                    <tr>
                        <td>Students whose seats are cancelled</td>
                        <td>{{ $no_seat_cancelled }}</td>
                        <td>
                            @auth
                                <a href="/hostel/{{ $hostel->id }}/cancelHostel" class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>
                    </tr>

                    <tr>
                        <td>Students whose submitted requirement for next semester</td>
                        <td>{{ $no_requirement }}</td>
                        <td>
                            @auth
                                <a href="/requirement/list?hostel_id={{ $hostel->id }}" class="btn btn-primary btn-sm">
                                    view
                                </a>
                            @endauth
                        </td>
                    </tr>

                    @if ($hostel->warden())
                        <tr>
                            <td>Warden</td>
                            <td>{{ $hostel->warden()->person->name }}</td>
                            @auth
                                <td></td>
                            @endauth
                        </tr>
                    @endif
                </tbody>

            </table>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Admission related
            </x-slot>
            <div class="form-group row mb-3">
                <label class="col-md-4">
                    No. of applicants approved:
                </label>
                <label class="col-md-4">
                    {{ $hostel->no_of_approved() }}
                </label>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-4">
                    No. of applicants notified:
                </label>
                <label class="col-md-4">
                    {{ $hostel->no_of_notified() }}
                </label>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-4">
                    No. of applicants who are allotted seats:
                </label>
                <label class="col-md-4">
                    {{ $hostel->no_of_seat_allotted() }}
                </label>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-4">
                    No. of applicants who are confirmed:
                </label>
                <label class="col-md-4">
                    {{ $hostel->no_of_confirmed() }}
                </label>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-4">
                    No. of applicants who are declined:
                </label>
                <label class="col-md-4">
                    {{ $hostel->no_of_declined() }}
                </label>
            </div>
        </x-block>
    </x-container>
</x-layout>
