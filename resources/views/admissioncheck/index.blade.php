<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission status of {{ $allotment->person->name }}
                <p>

                    <div class="btn-group">
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $allotment->valid_allot_hostel()->hostel->id }}/admission">Back</a>
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/allotment/{{ $allotment->id }}">Back to personal details</a></li>
                        @if($allotment->valid_allot_hostel())
                            <li><a class="dropdown-item" href="/hostel/{{ $allotment->valid_allot_hostel()->hostel->id }}/admission">Back to hostel admissions</a></li>
                        @else
                            <li><a class="dropdown-item" href="/hostel/{{ $allotment->hostel->id }}/admission">Back to hostel admissions</a></li>
                        @endif
                    </ul>
                    </div>

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
                        <input type="text" class="form-control" name="remark" value="{{ $allotment->person->other()->remark }}" disabled>
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
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-secondary btn-sm" href="/admission/{{ $admission->id }}/edit">Edit</a>
                                <button class="btn btn-danger btn-sm btn-delete" value="{{ $admission->id }}">Delete</button>

                            </div>

                        </td>
                    </tr>
                    @endforeach
                    <form method="post" name="frmDelete">
                        @csrf
                        @method('delete')
                    </form>
                </table>
            @else
                <h3>No hostel admission record available</h3>
            @endif
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $("button.btn-delete").click(function(){
        if(confirm("Are you sure you want to delete this admission detail?")){
            $("form[name='frmDelete']").attr('action','/admission/' + $(this).val());
            $("form[name='frmDelete']").submit();
        }
        // alert($(this).val());
    });
});
</script>
</x-layout>
