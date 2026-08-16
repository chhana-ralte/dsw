<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of payments received by Finance
            </x-slot>

            <div style="width: 100%; overflow-x:auto">
                @include('bulk_update.partials.menu')
                @if(auth()->user()->isAdmin())
                    <button class="btn btn-danger btn-lg btn-bulkupdate">Bulk Update</button>
                    <form method="post" type="hidden" id="bulkUpdate" action="/bulkupdate/bulkupdate">
                        @csrf
                    </form>
                @endif
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Application name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1 ?>
                        @foreach($results as $res)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td><a href='/bulkupdate/{{ $res->id }}/search'>{{ $res->name }}</a></td>
                                <td>{{ $res->course }}</td>
                                <td>{{ $res->amount }}</td>
                                <td>{{ $res->appl_name }}</td>
                                <td>{{ $res->application_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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

    $("button.btn-bulkupdate").click(function(){
        if (confirm('Are you sure you want to update in bulk?')){
            if (confirm('Really really sure????')){
                $("form#bulkUpdate").submit();
            }

        }
    });

    $("button.btn-admission").click(function(){
        $("input#allotment_id").val($(this).val());
        $("input[name='ref']").val('');
        $("input[name='amount']").val('');
        $("input[name='dt']").val('');
        $("input[name='type']").val('create');
        $("button.btn-add-admission").text("Add admission");
        $("div#admissionModal").modal("show");
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
