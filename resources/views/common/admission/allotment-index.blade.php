<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission details of {{ $allotment->person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                    @can('manages', App\Models\Admission::class)
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
                            @can('manages', App\Models\Admission::class)
                                <th>Action</th>
                            @endcan
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
                                @can('manages', App\Models\Admission::class)
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-secondary btn-sm btn-edit" href="/admission/{{ $adm->id }}/edit?back_link={{ $back_link }}">Edit</a>
                                            <button class="btn btn-danger btn-sm btn-delete" value="{{ $adm->id }}">Delete</button>
                                        </div>
                                    </td>
                                @endcan
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
                    <label for="sessn" class="col">Starting session (in the hostel)</label>
                    <div class="col">

                        <select class="form-control" name="sessn">
                            @foreach(App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get() as $ssn)
                                <option value="{{ $ssn->id }}" {{ App\Models\Sessn::current()->id == $ssn->id?' selected ':''}}>{{ $ssn->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="amount" class="col">Payment amount</label>
                    <div class="col">
                        <input type="text" class="form-control" name="amount" value="">
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
                <button type="button" class="btn btn-primary btn-add-admission" value="add-admission">Approve admission</button>
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
        $("div#admissionModal").modal("show");
    });

    $("button.btn-add-admission").click(function(){
        // alert(typeof $("input[name='amount']").val());
        if($("input[name='amount']").val() == '' || $("input[name='dt']").val() == ''){
            alert("Enter correct amount and date");
            exit();
        }
        else{
            $.ajax({
                url : "/ajax/allotment/" + $("input#allotment_id").val() + "/admission/store",
                type : "post",
                data : {
                    sessn_id : $("select[name=sessn]").val(),
                    amount : $("input[name='amount']").val(),
                    payment_dt : $("input[name='dt']").val(),
                },
                success : function(data,status){
                    if(data == "Successful"){
                        alert(data);
                        location.reload();
                    }
                    else{
                        alert(data);
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
