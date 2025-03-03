<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ $hostel->name }} Hall of Residence
            </x-slot>
            Summary
            <table class="table table-hover table-striped">
                <tr>
                    <td>Total number of rooms</td><td>{{ $rooms->count() }}</td>
                </tr>
                    <td>Total seats available for allocation</td><td>{{ $seats->sum('available') }}</td>
                </tr>
                    <td>Total number of students allotted</td><td>{{ $allotted_seats->count() }}</td>
                </tr>
                    <td>Total number of seats vacant</td><td>{{ $seats->sum('available')-$allotted_seats->count() }}</td>
                </tr>
                    <td>No. of students who are not allotted seat/room</td><td>{{ $unallotted_seats->count() }}</td>
                </tr>
            </table>
        </x-block>
        
        <x-block>
            <x-slot name="heading">
                Menu
            </x-slot>

            <section id="Menu">
                <div class="container">     
                    <div class="row mb-4">
                        <a class="col-sm-3 bg-primary" href="/hostel/{{ $hostel->id }}/room">
                            <div class="col col-md-4 bg-primary  mx-auto">
                                <span class="btn btn-primary">
                                    <h4>Rooms</h4>
                                </span>
                            </div>
                        </a>
                        <a class="col-sm-3 bg-secondary" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=1">
                            <div class="col col-md-4 mx-auto">
                                <span class="btn btn-secondary">
                                    <h4>Occupants</h4>
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="row mb-4">
                        <a class="col-sm-3 bg-primary" href="/hostel/{{ $hostel->id }}/room">
                            <div class="col col-md-4 bg-primary  mx-auto">
                                <span class="btn btn-primary">
                                    <h4>Vacant Rooms</h4>
                                </span>
                            </div>
                        </a>
                        <a class="col-sm-3 bg-secondary" href="/hostel/{{ $hostel->id }}/occupants?allot_seats=0">
                            <div class="col col-md-4 mx-auto">
                                <span class="btn btn-secondary">
                                    <h4>Students having no room</h4>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </x-block>
    </x-container>
</x-layout>
