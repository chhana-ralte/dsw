<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Room allotment for {{ $allot_hostel->allotment->person->name }} in {{ $allot_hostel->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/allotment/{{ $allot_hostel->allotment->id }}">back</a>
                </p>
            </x-slot>
            <div class="container">
                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="seat">Seat No.:</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="seat">

                        </select>
                        <input class="form-check-input" type="checkbox" value="1" id="available">
                        <label class="form-check-label" for="available">
                            Show only available rooms/seats
                        </label>
                    </div>
                </div>

                <div class="form-group row button_row mb-2" hidden>
                    <div class="col col-md-3">
                    
                    </div>
                    <div class="col col-md-4">
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                    </div>
                </div>
            </div>
        </x-block>
    </x-container>
<script>

function load_seats(){
    $.ajax({
        type : "get",
        url : "/ajax/get_all_seats?hostel_id={{ $allot_hostel->hostel->id }}",
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
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("input#available").click(function(){
        if($(this).prop('checked')){
            $.ajax({
                type : "get",
                url : "/ajax/get_available_seats?hostel_id={{ $allot_hostel->hostel->id }}",
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

    $("select#seat").change(function(){
        //alert("asdsad");
        if($(this).val() == 0){
            $(".button_row").attr("hidden",true);
        }
        else{
            $(".button_row").attr("hidden",false);
        }
    });


    $("button.submit").click(function(){
        //alert($("select#seat").val());
        if($("select#seat").val() != 0){
            $.ajax({
                type : "post",
                url : "/ajax/allot_seat_store",
                data : {
                    allot_hostel_id : "{{ $allot_hostel->id }}",
                    seat_id : $("select#seat").val()
                },
                success : function(data,status){
                    //alert(data);
                    alert("Successfully allotted");
                    location.replace("/allotment/{{ $allot_hostel->allotment->id }}");
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });
});
</script>
</x-layout>
