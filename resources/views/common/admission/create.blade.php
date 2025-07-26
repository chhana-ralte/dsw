<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seat allotment for newly allotted resident: {{ $allotment->person->name }}
                <p>
                    <a href="/hostel/{{ $allotment->hostel->id }}/admission?sessn_id={{ $sessn->id }}&adm_type=new" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>

            <form name="frm_submit" method="post" action="/allotment/{{ $allotment->id }}/admission">
                @csrf
                <input type="hidden" name="type" value="new">
                <input type="hidden" name="sessn_id" value="{{ $sessn->id }}">
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
                    <label for="hostel" class="col col-md-3">Hostel allotted</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="hostel" value="{{ $allotment->hostel->name }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="roomtype" class="col col-md-3">Allotted room type</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="roomtype" value="{{ App\Models\Room::room_type($allotment->roomtype) }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <label for="admitted">Admission done?</label>
                        <input type="checkbox" name="admitted" id="admitted" {{ old('admitted')?' checked ':''}}>
                    </div>
                </div>

                <div class="admission">
                    <div class="form-group row mb-3">
                        <label for="sessn" class="col col-md-3">Starting session</label>
                        <div class="col col-md-4">

                            <select class="form-control" name="sessn">
                                @foreach(App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get() as $ssn)
                                    <option value="{{ $ssn->id }}" {{ $allotment->start_sessn_id==$ssn->id?' selected ':''}}>{{ $ssn->name() }}</option>
                                @endforeach
                            </select>
                            @error('sessn')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="amount" class="col col-md-3">Payment amount</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="dt" class="col col-md-3">Payment date</label>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="dt" value="{{ old('dt') }}" required>
                            @error('dt')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="seat">Seat No.:</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="seat" name="seat">

                        </select>
                        <input class="form-check-input" type="checkbox" value="1" id="available" checked>
                        <label class="form-check-label" for="available">
                            Show only available rooms/seats
                        </label>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary submit">Submit</button>
                        <button type="button" class="btn btn-danger decline">Decline</button>
                    </div>
                </div>

            </form>
            <form method="post" name="frm_decline" action="/allotment/{{ $allotment->id }}/admission_decline">
                @csrf
            </form>
        </x-block>
    </x-container>
<script>


function load_seats(){
    $.ajax({
        type : "get",
        url : "/ajax/get_all_seats?hostel_id={{ $allotment->hostel->id }}",
        success : function(data,status){
            var s="<option value='0'>Select Seat</option>";

            for(i=0; i<data.length; i++){
                if({{ old('seat',0) }} == data[i].id){
                    s += "<option value='" + data[i].id + "' selected>Seat: " + data[i].serial + " of " + data[i].roomno + "(" + data[i].room_type + ")</option>";
                }
                else{
                    s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i].roomno + "(" + data[i].room_type + ")</option>";
                }

            }
            $("select[id='seat']").html(s);
            //alert(data[0].roomno);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // // Analyze the error
            // console.log('jqXHR:', jqXHR);
            // console.log('textStatus:', textStatus);
            // console.log('errorThrown:', errorThrown);

            // // Access Laravel validation errors (if status is 422)
            // if (jqXHR.status === 422) {
            //     var errors = jqXHR.responseJSON.errors;
            //     console.log('Validation Errors:', errors);
            //     // Display validation errors to the user
            // } else {
            //     // Handle other types of errors
            //     console.log('Server Error:', jqXHR.responseText);
            // }
            alert("Error");
        }
    });
}

function load_available_seats(){
    $.ajax({
        type : "get",
        url : "/ajax/get_available_seats?hostel_id={{ $allotment->hostel->id }}",
        success : function(data,status){
            var s="<option value='0'>Select Seat</option>";
            for(i=0; i<data.length; i++){
                if({{ old('seat',0) }} == data[i].id){
                    s += "<option value='" + data[i].id + "' selected>Seat: " + data[i].serial + " of " + data[i].roomno + "(" + data[i].room_type + ")</option>";
                }
                else{
                    s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i].roomno + " (" + data[i].room_type + ")</option>";
                }
            }
            $("select[id='seat']").html(s);
            //alert(data[0].roomno);
        },
        error : function(){
            alert("Error");
        }
    });
}

load_available_seats();


$(document).ready(function(){
    if($("input[name='admitted']").prop('checked')){
        $("div.admission").show();
    }
    else{
        $("div.admission").hide();
    }

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

    $("input[name='admitted']").click(function(){
        if($(this).prop('checked')){
            $("div.admission").show();
        }
        else{
            $("div.admission").hide();
        }
    });

    $("input#available").click(function(){
        if($(this).prop('checked')){
            load_available_seats();
        }
        else{
            load_seats();
        }
    });

    $("button.submit").click(function(){

        if($("select#seat").val() == 0){
            alert("Make sure the seat is selected");
            exit();
        }
        $("form[name='frm_submit']").submit();
    });

    $("button.decline").click(function(){
        if(confirm("Are you sure the student won't do admission?")){
            $("form[name='frm_decline']").submit();
            alert("Successful");
        }
    });
});
</script>
</x-layout>
