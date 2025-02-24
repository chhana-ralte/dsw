<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Room allotment for {{ $allot_hostel->person->name }} in {{ $allot_hostel->hostel->name }}
            </x-slot>
            <div class="container">
                <div class="form-group row">
                    <div class="col col-md-3">
                        <label for="roomno">Room No.:</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="roomno">
                            <option value="0">Select Room No.</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->roomno }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row seat_row" hidden>
                    <div class="col col-md-3">
                        <label for="seat">Seat No.:</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="seat">
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row button_row" hidden>
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
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("select#roomno").change(function(){
        //alert("asdsad");
        if($(this).val() == 0){
            $(".seat_row").attr("hidden",true);
        }
        else{
            $(".seat_row").attr("hidden",false);
            $.ajax({
                type : "get",
                url : "/ajaxroom/" + $("#roomno").val() + "/seat",
                success : function(data,status){
                    s = "<option value='0'>None</option>"
                    for(i=0;i<data.length;i++){
                        s += "<option value='" + data[i].id + "'>" + data[i].serial + "</option>";
                    }
                    $("select#seat").html(s);
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });

    $("select#seat").change(function(){
        if($(this).val() == 0){
            $(".button_row").attr("hidden",true);
        }
        else{
            $(".button_row").attr("hidden",false);
        }
    });

    $("button.submit").click(function(){
        alert($("select#seat").val());
        if($("select#seat").val() != 0){
            $.ajax({
                type : "post",
                url : "/ajax/allot_seat_store",
                data : {
                    allot_hostel_id : "{{ $allot_hostel->id }}",
                    seat_id : $("select#seat").val()
                },
                success : function(data,status){
                    alert(data);
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
