<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Admission for newly allotted student {{ $allotment->person->name }}
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
                        <input type="text" class="form-control" name="mzuid" value="{{ $allotment->hostel->name }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <label for="admitted">Admission done?</label>
                        <input type="checkbox" name="admitted" id="admitted">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="seat">Seat No.:</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="seat" name="seat">

                        </select>
                        <input class="form-check-input" type="checkbox" value="1" id="available">
                        <label class="form-check-label" for="available">
                            Show only available rooms/seats
                        </label>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary submit">Admit</button>
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
                s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i].roomno + "</option>";
            }
            $("select[id='seat']").html(s);
            //alert(data[0].roomno);
        },
        error : function(){
            alert("Error");
        }
    });
}
load_seats();

$(document).ready(function(){
    $("div.student").hide();
    $("div.other").hide();

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

    $("input#available").click(function(){
        if($(this).prop('checked')){
            $.ajax({
                type : "get",
                url : "/ajax/get_available_seats?hostel_id={{ $allotment->hostel->id }}",
                success : function(data,status){
                    var s="<option value='0'>Select Seat</option>";
                    for(i=0; i<data.length; i++){
                        s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i].roomno + "</option>";
                    }
                    $("select[id='seat']").html(s);
                    //alert(data[0].roomno);
                },
                error : function(){
                    alert("Error");
                }
            });
        }
        else{
            load_seats();
        }
    });

    $("button.submit").click(function(){

        if($("select#seat").val() != 0){
            $("form[name='frm_submit']").submit();
        }
        else{
            alert("Make sure the seat is selected")
        }
    });

    $("button.decline").click(function(){
        if(confirm("Are you sure the student won't do admission?")){
            $("form[name='frm_decline']").submit();
            alert("asdasds");
        }
    });
});
</script>
</x-layout>
