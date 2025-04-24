<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Cancel allotment
                <p>
                    <a href="/allotment/{{ $allotment->id }}" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Please check whether the following information is correct for seat cancellation
            </x-slot>
            <form name="frmSubmit" method="post" action="/allotment/{{ $allotment->id }}/cancelSeat">
                @csrf

                <input type="hidden" name="allotment_id" value="{{ $allotment->id }}">
                @if($allot_hostel)
                    <input type="hidden" name="allot_hostel_id" value="{{ $allot_hostel->id }}">
                @endif

                @if($allot_seat)
                    <input type="hidden" name="allot_seat_id" value="{{ $allot_seat->id }}">
                @endif

                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Name</label>
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
                    </div>
                    <div class="col col-md-4">
                        
                        <input type="checkbox" id="completed" name="completed" checked>
                        <label for="completed">Whether course completed?</label>
                        <br>
                        <input type="checkbox" id="cleared" name="cleared" checked>
                        <label for="cleared">Whether fee cleared?</label>
                        <br>
                    </div>
                </div>
                
                <div class="form-group row mb-3 outstanding">
                    <label class="col col-md-3">Any outstanding amount</label>
                    <div class="col col-md-4">
                        <input name="outstanding" type="number" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col col-md-3">Actual date of leaving/ proposed date of leaving</label>
                    <div class="col col-md-4">
                        <input name="leave_dt" type="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col col-md-3">Date of issue</label>
                    <div class="col col-md-4">
                        <input name="issue_dt" type="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="remark">Remark(s)</label>
                    </div>
                    <div class="col col-md-4">
                        <textarea class="form-control" id="remark" name="remark"></textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary submit">Confirm</button>
                    </div>
                </div>

            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){

    $("div.outstanding").hide();

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

    $("input#cleared").click(function(){
        if($(this).is(":checked")){
            $("div.outstanding").hide();
        }
        else{
            $("div.outstanding").show();
        }
    });

    $("button.submit").click(function(){
        if( !$("input#cleared").is(":checked") && $("input[name='outstanding']").val() == 0){
            alert("If fee is not cleared, amount can not be zero/null");
            exit();
        }
        if(confirm("Are you sure you want to disallocate the inmate? Only DSW would be able to revert.")){   
            $("form[name='frmSubmit']").submit();
        }
    });
});
</script>
</x-layout>
