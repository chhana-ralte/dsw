<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission status of {{ $allotment->person->name }}
                <p>
                    @if($allotment->valid_allot_hostel())
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $allotment->valid_allot_hostel()->hostel->id }}/admission">Back</a>
                    @else
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $allotment->hostel->id }}/admission">Back</a>
                    @endif
                    @can('manage',$allotment)
                        <a class="btn btn-primary btn-sm" href="/allotment/{{ $allotment->id }}/admission/create">New entry</a>
                    @endcan
                </p>
            </x-slot>
            @if($allotment->person->student())
                <div class="form-group row mb-3">
                    <label for="mzuid" class="col col-md-3">Mzuid</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mzuid" value="{{ $allotment->person->student()->mzuid }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="rollno" class="col col-md-3">Roll No.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="rollno" value="{{ $allotment->person->student()->rollno }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="department" class="col col-md-3">Department</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="department" value="{{ $allotment->person->student()->department }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="course" class="col col-md-3">Course</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="course" value="{{ $allotment->person->student()->course }}" disabled>
                    </div>
                </div>

            @elseif($allotment->person->other())

                <div class="form-group row mb-3">
                    <label for="remark" class="col col-md-3">Remark</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="remark" value="{{ $allotment->person->student()->remark }}" disabled>
                    </div>
                </div>

            @endif

            @if($allotment->valid_allot_hostel())
                <div class="form-group row mb-3">
                    <label for="hostel" class="col col-md-3">Current Hostel</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="hostel" value="{{ $allotment->valid_allot_hostel()->hostel->name }}" disabled>
                    </div>
                </div>
            @endif
            

            @if(count($admissions) > 0)
                <table class="table">
                    <tr>
                        <th>Session</th>
                        <th>Amount paid</th>
                        <th>Payment date</th>
                        <th>Remarks</th>
                        <th>Manage</th>
                    </tr>
                    @foreach($admissions as $admission)
                    <tr>
                        <td>{{ $admission->sessn->name() }}</td>
                        <td>{{ $admission->amount }}</td>
                        <td>{{ $admission->payment_dt }}</td>
                        <td>{{ $admission->remark }}</td>
                        <td><a href="/admission/{{ $admission->id }}/edit">Edit</a></td>
                    </tr>
                    @endforeach
                </table>
            @else
                <h3>No hostel admission record available</h3>
            @endif
        </x-block>
    </x-container>
</x-layout>
