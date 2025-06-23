<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Requirement details {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/requirement">Back to
                        requirement</a>
                </p>

                <p>
                    <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/requirement_list?status=Applied">Applied</a>
                    <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/requirement_list?status=Resolved">Resolved</a>
                </p>

            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form method="post" action="/hostel/{{ $hostel->id }}/requirement_list">
                    @csrf
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Student info</th>
                                <th>Current</th>
                                <th>Requirement</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requirements as $req)
                                <tr>

                                    <td>
                                        <input type="checkbox" name="requirement_id[]" value="{{ $req->id }}">
                                    </td>
                                    <td>
                                        @can('view', $req->allot_hostel->allotment)
                                            {{ $req->person->name }}
                                        @else
                                            {{ $req->person->name }}
                                        @endcan
                                    </td>

                                    <td>
                                        @if ($req->person->student())
                                            ({{ $req->person->student()->department }}: {{ $req->person->student()->course }})
                                        @elseif($req->person && $req->person->other())
                                            Not a student ({{ $req->person->other()->remark }})
                                        @else
                                            ( No Info about the person )
                                        @endif
                                    </td>

                                    <td>
                                        Hostel: {{ $req->allot_hostel->hostel->name }}<br>
                                        Type: {{ $req->roomType() }}
                                    </td>
                                    <td>
                                        Hostel: {{ $req->hostel->name }}<br>
                                        Type: {{ $req->roomtype() }}
                                    </td>
                                    @if ($req->new_hostel_id)
                                        <td>
                                            Hostel: {{ $req->new_hostel()->name }}<br>
                                            Type: {{ $req->new_roomtype() }}
                                        </td>
                                    @else
                                        <td>
                                            <select class="form-control" name="new_hostel_id[{{ $req->id }}]">
                                                <option value="0">Select Hostel</option>
                                                @foreach(App\Models\Hostel::where('gender', $req->hostel->gender)->get() as $hostel)
                                                    <option value="{{ $hostel->id }}" {{ $req->hostel->name == $hostel->name ? 'selected' : ''}}>{{ $hostel->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control" name="new_roomcapacity[{{ $req->id }}]">
                                                <option value="0">Select Room Capacity</option>
                                                <option value="1" {{ $req->roomType() == 'Single' ? 'selected' : ''}}>Single</option>
                                                <option value="2" {{ $req->roomType() == 'Double' ? 'selected' : ''}}>Double</option>
                                                <option value="3" {{ $req->roomType() == 'Triple' ? 'selected' : ''}}>Triple</option>
                                                <option value="4" {{ $req->roomType() == 'Dormitory' ? 'selected' : ''}}>Dormitory</option>
                                            </select>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                        <footer>
                            <tr>
                                <td colspan="6">
                                    <button class="btn btn-primary" type="submit">Update for selected hostellers</button>
                                </td>
                            </tr>
                        </footer>
                    </table>
                </form>
            </div>
        </x-block>

    </x-container>
</x-layout>
