<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission details of {{ $allotment->person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                    {{-- @can('manages', App\Models\Admission::class)
                        <button class="btn btn-primary btn-sm btn-admission" value="{{ $allotment->id }}">Add admission payment</button>
                    @endcan --}}
                    @can('create-admission', $allotment)
                        <button class="btn btn-primary btn-sm btn-admission" value="{{ $allotment->id }}">Add admission payment</button>
                    @endcan
                </p>
            </x-slot>
            <form>
                <input type="hidden" id="allotment_id" value="{{ $allotment->id }}">
            </form>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Session</th>
                            <th>Payment amount</th>
                            <th>Payment date</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1 ?>
                        @foreach($admissions as $adm)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ $adm->sessn->name() }}</td>
                                <td>{{ $adm->amount }}</td>
                                <td>{{ $adm->payment_dt }}</td>
                                <td>{{ $adm->verified?'Verified':'Created' }}</td>
                                <td>
                                    @can('update-admission', $adm)
                                        <div class="btn-group">
                                            {{-- <a class="btn btn-secondary btn-sm btn-edit" href="/admission/{{ $adm->id }}/edit?back_link=/allotment/{{ $adm->allotment->id }}/admission?back_link={{ $back_link }}">Edit</a> --}}
                                            <button class="btn btn-secondary btn-sm btn-edit" value="{{ $adm->id }}">Edit</button>
                                            <button class="btn btn-danger btn-sm btn-delete" value="{{ $adm->id }}">Delete</button>
                                            @can('verify-admission', $adm)
                                                @if(!$adm->verified)
                                                    <button class="btn btn-primary btn-sm btn-verify" value="{{ $adm->id }}">Verify</button>
                                                @else
                                                    <button class="btn btn-primary btn-sm btn-undo-verify" value="{{ $adm->id }}">Undo Verify</button>
                                                @endif
                                            @endcan
                                        </div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>
    </x-container>

{{-- Modal for admission --}}

<form>
    <input type="hidden" name="allotment_id" id="allotment_id">
    <input type="hidden" name="admission_id" id="admission_id">
    <input type="hidden" name="type" id="type">
</form>

<div class="modal fade" id="admissionModal" tabindex="-1" aria-labelledby="admissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="admissionModalLabel">Assign admission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="sessn" class="col">Payment for session</label>
                    <div class="col">
                        <select class="form-control" name="sessn">
                            @foreach(App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get() as $ssn)
                                <option value="{{ $ssn->id }}" {{ App\Models\Sessn::current()->id == $ssn->id?' selected ':''}}>{{ $ssn->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="ref" class="col-form-label">Reference No.:</label>
                    <input class="form-control" type="text" name="ref">
                </div>

                <div class="form-group mb-3">
                    <label for="amount" class="col">Payment amount</label>
                    <div class="col">
                        <input type="number" class="form-control" name="amount" value="" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="dt" class="col">Payment date</label>
                    <div class="col">
                        <input type="date" class="form-control" name="dt" value="{{ old('dt') }}" required>
                        @error('dt')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-add-admission" value="add-admission" id="add-admission">Add admission</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal for admission --}}



<script>

$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
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
            }
            else{
                var url = "/ajax/admission/" + $("input[name='admission_id']").val() + "/update";
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
                    // alert(data);
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
                    alert("Error");
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
