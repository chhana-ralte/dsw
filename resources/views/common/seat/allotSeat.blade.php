<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seat allotment for {{ $seat->room->roomno }}/{{ $seat->serial }} in {{ $seat->room->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $seat->room->id }}">back</a>
                </p>
            </x-slot>
            <div class="container">
                @if($seat->available != 0)
                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="search">Search</label>
                    </div>
                    <div class="col col-md-4">
                        <input class="form-control" name="search" id="search">
                    </div>
                </div>
                @else
                <div class="form-group row mb-2">
                    <div class="col col-md-3">
                        <label for="search">Seat is not available. Click <a href="/seat/{{ $seat->id }}/edit">here</a> to make it available</label>
                    </div>
                </div>
                @endif


                <div class="searching" hidden>
                    <div class="form-group row mb-2 table-content">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="table-header">
                                    <th></th>
                                    <th>Name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody id="content">

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row mb-2">
                        <div class="col col-md-4 button-row">
                            <button type="button" class="btn btn-primary select">Select</button>
                        </div>
                    </div>
                </div>



                <div class="searched" hidden>
                    <div class="form-group row mb-2">
                        <div class="col col-md-4 button-row">
                            <button type="button" class="btn btn-primary allot">Allot</button>
                        </div>
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

    $("input#search").keyup(function(){
        var str = $(this).val();
        if(str.length > 2){
            $.ajax({
                type : "get",
                url : "/ajax/hostel/" + {{ $seat->room->hostel->id }} + "/allot_hostel?search=" + str,
                success : function(data,status){
                    var s = "";
                    if(data.length > 0){
                        $("div.searching").attr("hidden",false);
                        for(i=0; i<data.length; i++){
                            s += "<tr class='data-row' id='" + data[i].id +"'>";
                            s += "<td><input type='radio' name='allot_hostel' value='" + data[i].id + "'></td>";
                            s += "<td>" + data[i].name + "</td>";
                            s += "<td>" + data[i].address + "</td>";
                            s += "</tr>";
                        }
                    }
                    else{
                        $("div.searching").attr("hidden",true);
                    }
                    $("#content").html(s);
                },
                error : function(){
                    alert("Error");
                }
            });
            //alert($(this).val());
            $("div.searched").attr('hidden',true);
        }
        
    });





    $("button.select").click(function(){
        if($("input[name='allot_hostel']:checked").val()){
            //alert($("input[name='allot_hostel']:checked").val());
            $("tr.data-row").hide();
            $("tr[id='"+ $("input[name='allot_hostel']:checked").val() +"']").show();
            $("div.searched").attr('hidden',false);
        }
        else{
            alert("Select one person from the list");
        }

    });

    $("button.allot").click(function(){
        var allot_hostel_id = $("input[name='allot_hostel']:checked").val();
        $.ajax({
            type : "post",
            url : "/seat/{{ $seat->id }}/allotSeat",
            data : {
                allot_hostel_id : $("input[name='allot_hostel']:checked").val(),
            },
            success : function(data,status){
                alert("Successfully allotted");
                location.replace("/room/" + {{ $seat->room->id }});
            },
            error : function(){
                alert("Error");
            }
        });
        //alert($("input#seat_id").val());
    });

});
</script>
</x-layout>
