<x-layout>
    <x-container>
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
        <x-block>
            <x-slot name="heading">
                {{ $hostel->name }} Hall of Residence
            </x-slot>
            Summary
            <table class="table table-hover table-striped">
                <tbody>
                    <tr>
                        <td>Total number of rooms</td>
                        <td>{{ $no_rooms }}</td>
                        <td>
                            <a href="/hostel/{{ $hostel->id }}/room" type="button" class="btn btn-primary btn-sm">
                                view
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Total number of seats</td>
                        <td>{{ $no_seats }}</td>
                        <td>
                            <a href="/hostel/{{ $hostel->id }}/room" type="button" class="btn btn-primary btn-sm">
                                view
                            </a>
                        </td>
                    </tr>
                    <td>Total seats available for allotment</td>
                    <td>{{ $no_available_seats }}</td>
                    <td>
                        <a href="/hostel/{{ $hostel->id }}/room?status=vacant" type="button"
                            class="btn btn-primary btn-sm">
                            view
                        </a>
                    </td>
                    </tr>
                    <td>Total number of students allotted</td>
                    <td>{{ $no_allotted_seats }}</td>
                    <td>
                        <a href="/hostel/{{ $hostel->id }}/room?status=non-available" type="button"
                            class="btn btn-primary btn-sm">
                            view
                        </a>
                    </td>
                    </tr>
                    {{-- <td>Total number of seats vacant</td>
                    <td>{{ no_vacant_seats }}</td>
                    </tr> --}}
                    <td>No. of students who are not allotted seat/room</td>
                    <td>{{ $no_unallotted }}</td>
                    <td></td>
                    </tr>
                </tbody>
            </table>
        </x-block>


    </x-container>
</x-layout>
