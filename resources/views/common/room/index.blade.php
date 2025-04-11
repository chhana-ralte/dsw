<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                <div class="justify-between row">
                    <div class="col">
                        Rooms in {{ $hostel->name }} Hall of Residence
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item" href="/hostel/{{ $hostel->id }}/room">All rooms</a></li>
                                <li><a class="dropdown-item"
                                        href="/hostel/{{ $hostel->id }}/room?status=vacant">Vacant
                                        rooms/seats</a></li>
                                <li><a class="dropdown-item"
                                        href="/hostel/{{ $hostel->id }}/room?status=non-available">Non-available
                                        rooms/seats</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="justify-between row">
                    <div class="col-auto">
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">back</a>
                    </div>
                    @auth
                        @if(auth()->user()->isWardenOf($hostel->id))
                            <div class="col-auto">
                                <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/room/create">Create new
                                    room</a>
                            </div>
                        @endif
                    @endauth
                </div>

            </x-slot>
            
            @if (count($rooms) > 0)
                <div style="width: 100%; overflow-x: auto; ;">
                    <table class="table table-auto table-hover" style="border-collapse: collapse">
                        <thead>
                            <tr>
                                <th>Room No</th>
                                <th>Capacity</th>
                                <th>Available</th>
                                <th>Filled</th>
                                <th>Vacancy</th>
                                <th>Remarks</th>
                                @auth
                                    @can('update',$hostel)
                                        <th style=" ">Manage</th>
                                    @endcan
                                @endauth
                            <tr>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $capacity = 0;
                                $available = 0;
                                $filled = 0;
                            ?>
                            @foreach ($rooms as $r)
                                <?php 
                                    $capacity += $r->capacity;
                                    $available += $r->available;
                                    $filled += $r->filled()->count();
                                ?>
                                @if ($r->capacity == $r->available)
                                    <tr class="table-default">
                                    @else
                                    <tr class="table-danger">
                                @endif

                                <td><a href="/room/{{ $r->id }}">{{ $r->roomno }}</a></td>
                                <td>{{ $r->capacity }}</td>
                                <td>{{ $r->available }}</td>
                                <td>{{ $r->filled()->count() }}</td>
                                <td>{{ $r->available - $r->filled()->count() }}</td>
                                <td>
                                    @if (count($r->remarks))
                                        <ul>
                                            @foreach ($r->remarks as $rm)
                                                <li>{{ $rm->remark_dt }}: {{ $rm->remark }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                @auth
                                    @can('update',$r->hostel)
                                        <td style="   z-index: 2 !important">
                                            <div class="dropdown" style="">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    ...
                                                </a>
                                                <ul class="dropdown-menu" style="z-index: 200">
                                                    <li><a class="dropdown-item"
                                                            href="/room/{{ $r->id }}/remark">Remark</a></li>
                                                    <li><a class="dropdown-item" href="/room/{{ $r->id }}/edit">Edit
                                                            Room</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    @endcan
                                @endauth
                                </tr>
                            @endforeach
                            <tr>
                                <th>Total</th>
                                <th>{{ $capacity }}</th>
                                <th>{{ $available }}</th>
                                <th>{{ $filled }}</th>
                                <th>{{ $available - $filled }}</th>
                                <th></th>
                                @auth
                                    @can('update',$hostel)
                                        <th></th>
                                    @endcan
                                @endauth
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                No Room available
            @endif    
        </x-block>
    </x-container>
</x-layout>
