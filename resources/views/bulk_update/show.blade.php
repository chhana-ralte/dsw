<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Payment details for {{ $payment->name }}
            </x-slot>

            <div style="width: 100%; overflow-x:auto">
                @include('bulk_update.partials.menu')
                <table class="table table-hover table-auto">
                    <tr>
                        <th>ID</th>
                        <th>{{ $payment->id }}</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>{{ $payment->name }}</th>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <th>{{ $payment->course }}</th>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <th>{{ $payment->amount }}</th>
                    </tr>
                    <tr>
                        <th>MZU ID</th>
                        <th>{{ $payment->mzuid }}</th>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>
                            @if($payment->admission())
                                Admission updated
                            @elseif($payment->application_id)
                                Application linked
                                <button type="button" class='btn btn-primary btn-sm btn-update' value="{{ $payment->id }}">Update payment</button>
                            @elseif($payment->appl_mzuid())
                                Available for linking
                                <button type="button" class='btn btn-primary btn-sm link-btn' value="{{ $payment->id }}">Link</button>
                            @else
                                No link available
                                <a href='/bulkupdate/{{ $payment->id }}/search' class='btn btn-primary btn-sm'>Search link</a>
                            @endif
                        </th>
                    </tr>
                    @if($payment->admission())
                        <tr><th colspan="2">Linked application information</th></tr>
                        <tr>
                            <th>Application name</th>
                            <th>{{ $payment->application()->name }}</th>
                        </tr>
                    @elseif($payment->application_id)
                        <tr><th colspan="2">Linked application information</th></tr>
                        <tr>
                            <th>Application name</th>
                            <th>{{ $payment->application()->name }}</th>
                        </tr>
                    @elseif($payment->appl_mzuid())
                        <tr><th colspan="2">Available MZU ID information</th></tr>
                        <tr>
                            <th>Application name</th>
                            <th>{{ $payment->appl_mzuid()->name }}</th>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <th>{{ $payment->appl_mzuid()->course }}</th>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <th>{{ $payment->appl_mzuid()->status }}</th>
                        </tr>
                        <tr>
                            <th>Hostel and room type</th>
                            <th>{{ $payment->appl_mzuid()->hostel->name }} -
                                {{ \App\Models\Room::room_type($payment->appl_mzuid()->roomtype) }}</th>
                        </tr>
                    @endif
                </table>
            </div>
        </x-block>
    </x-container>




<script>

$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });


    $("button.link-btn").click(function(){
        $.ajax({
            type : 'post',
            url : '/bulkupdate/link',
            data : {
                payment_id : $(this).val(),
            },
            success : function(data, status){
                //alert("Link successful");
                // console.log(status);
                console.log(data);
                location.reload();
            },
            error : function(){
                alert("Error");
            }

        });

    });

    $("button.btn-update").click(function(){
        // alert("asdasd");
        $.ajax({
            type : 'post',
            url : '/bulkupdate/admissionUpdate',
            data : {
                payment_id : $(this).val(),
            },
            success : function(data, status){
                alert("Link successful");
                console.log(status);
                console.log(data);
                location.reload();
            },
            error : function(){
                alert("Error");
            }

        });

    });


















    $("button.btn-verify").click(function(){
        if(confirm("Do you want to verify?")){
            $.ajax({
                type : 'post',
                url : '/ajax/admission/' + $(this).val() + '/verify',
                success : function(data, status){
                    alert("Verified");
                    location.reload();
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });

    $("button.btn-undo-verify").click(function(){
        if(confirm("Do you want to undo verification?")){
            $.ajax({
                type : 'post',
                url : '/ajax/admission/' + $(this).val() + '/undo-verify',
                success : function(data, status){
                    alert("Verification undone");
                    location.reload();
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });

    $("button.btn-edit").click(function(){
        var admission_id = $(this).val();

        $.ajax({
            type : "get",
            url : '/admission/' + admission_id + '?json=1',
            success : function(data, status){
                $("input#admission_id").val(data.id);
                $("input[name='ref']").val(data.ref);
                $("input[name='amount']").val(data.amount);
                $("input[name='dt']").val(data.payment_dt);
                $("input[name='type']").val('update');
                $("button.btn-add-admission").text("Update admission");
                $("select[name='sessn']").val(data.sessn_id).trigger('change');
                $("div#admissionModal").modal("show");

            },
            error : function(){
                alert("Error");
            }
        });
    });


    $("button.btn-add-admission").click(function(){
        // alert(typeof $("input[name='amount']").val());
        if($("input[name='amount']").val() == '' || $("input[name='dt']").val() == ''){
            alert("Enter correct amount and date");
            exit();
        }
        else{
            if($("input[name='type']").val() == 'create'){
                var url = "/ajax/allotment/" + $("input#allotment_id").val() + "/admission/store";
                console.log("Allotment id : " + $("input#allotment_id").val())
            }
            else{
                var url = "/ajax/admission/" + $("input[name='admission_id']").val() + "/update";
                console.log("Admission id : " + $("input[name='admission_id']").val())
            }
            $.ajax({
                url : url,
                type : "post",
                data : {
                    admission_id : $("input[name='admission_id']").val(),
                    sessn_id : $("select[name=sessn]").val(),
                    ref : $("input[name='ref']").val(),
                    amount : $("input[name='amount']").val(),
                    type : $("input[name='type']").val(),
                    payment_dt : $("input[name='dt']").val(),
                },
                success : function(data,status){
                    console.log(JSON.stringify(data));
                    if(data.status == true){
                        alert("Successful");
                        console.log(JSON.stringify(data));
                        location.reload();
                    }
                    else{
                        alert(data);
                        location.reload();
                    }
                },
                error : function(){
                    alert("Error occured");
                }
            });
        }

        // alert("hehe");
    });


    $("button.btn-delete").click(function(){
        if(confirm("Are you sure you want to delete this record?")){


            $.ajax({
                type : "delete",
                url : "/admission/" + $(this).val(),
                data : {
                    method : 'delete'
                },
                success : function(data, status){
                    alert(data);
                    location.reload();
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
