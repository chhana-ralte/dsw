<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Allotment
                <p>
                    <a href="/allotment/{{ $allotment->id }}" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Personal information
            </x-slot>
            <form name="frmcreate" method="post" action="/allotment/{{ $allotment->id }}/allot_hostel">
                @csrf
                @if($allotment->valid_allot_hostel())
                    <input type="hidden" name="current_hostel_id" value="{{ $allotment->valid_allot_hostel()->hostel_id }}">
                @elseif(count($allotment->allot_hostels) > 0)
                    <input type="hidden" name="current_hostel_id" value="0">
                @else
                    <input type="hidden" name="current_hostel_id" value="{{ $allotment->hostel_id }}">
                @endif
                <input type="hidden" name="current_hostel_id" value="{{ $allotment->valid_allot_hostel()?$allotment->valid_allot_hostel()->hostel_id: $allotment->hostel_id }}">
                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Name*</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ $allotment->person->name }}" disabled>
                    </div>
                </div>

                @if($allotment->person->student())
                    <div class="form-group row mb-3">
                        <label for="rollno" class="col col-md-3">Rollno</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="rollno" value="{{ $allotment->person->student()->rollno }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="course" class="col col-md-3">Course</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="course" value="{{ $allotment->person->student()->course }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="department" class="col col-md-3">Department*</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="department" value="{{ $allotment->person->student()->department }}" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3">
                        <label for="mzuid" class="col col-md-3">MZU ID</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="mzuid" value="{{ $allotment->person->student()->mzuid }}" disabled>
                        </div>
                    </div>
                @elseif($allotment->person->other())
                    <div class="form-group row mb-3">
                        <label for="remark" class="col col-md-3">Remark*</label>
                        <div class="col col-md-4">
                            <textarea class="form-control" name="remark" disabled>{{ $allotment->person->other()->remark }}</textarea>
                        </div>
                    </div>
                @endif
                <div class="form-group row mb-3">
                    <label class="col col-md-3">Hostel initially allotted</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" value="{{ $allotment->hostel->name }}" disabled>
                    </div>
                </div>
                @if($allotment->valid_allot_hostel())
                    <div class="form-group row mb-3">
                        <label class="col col-md-3">Hostel currently allotted</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" value="{{ $allotment->valid_allot_hostel()->hostel->name }}" disabled>
                        </div>
                    </div>
                @endif
                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="hostel">Hostel to be allotted</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="hostel" name="hostel">
                            <option value="0">Select Hostel</option>
                            @foreach(\App\Models\Hostel::orderBy('gender')->orderBy('name')->get() as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary submit">Submit</button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });


    $("button.submit").click(function(){
        if($("select[name='hostel']").val() == 0){
            alert("Select the hostel");
            exit();
        }
        if($("select[name='hostel']").val() == $("input[name='current_hostel_id']").val()){
            alert("Current hostel can not be same as currently allotted hostel");
            exit();
        }
        $("form[name='frmcreate']").submit();
    });
});
</script>
</x-layout>
