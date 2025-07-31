<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission status of residents of {{ $hostel->name }} Hall of Residence for the {{ $sessn->name() }} session.
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>


                    @if($adm_type == 'old')
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}&adm_type=new">New admissions</a>
                    @else
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}">Existing admissions</a>
                    @endif
                    <input style="font-size:15px" type="text" name="find"/>
                </p>
            </x-slot>
            <h3>Existing Occupants</h3>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        
                        <tr>
                            <th>Seat No.</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Status</td>
                            
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allot_hostels as $ah)
                            <tr class="table-white row_{{ $ah->id }}">
                                @if( $ah->valid_allot_seat())
                                    <td>{{ $ah->valid_allot_seat()->seat->room->roomno }}/{{ $ah->valid_allot_seat()->seat->serial }}</td>
                                @else
                                    <td><i>N.A.</i></td>
                                @endif
                                <td class="name">{{ $ah->allotment->person->name }}</td>
                                @if($ah->allotment->person->student())
                                    <td>{{ $ah->allotment->person->student()->department }}</td>
                                @elseif($ah->allotment->person->other())
                                    <td><b>Not a student ({{ $ah->allotment->person->other()->remark }})</b></td>
                                @else
                                    <td><b>No info</b></td>
                                @endif
                                <td>
                                    @if($ah->allotment->admission($sessn->id))
                                        <label id="label_{{ $ah->id }}">Done</label>
                                    @else
                                        <label id="label_{{ $ah->id }}">Not done</label>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @can('manages',App\Models\Admission::class)
                                            @if($ah->allotment->admission($sessn->id))
                                                <button class="btn btn-danger btn-sm btn-undo" name="admit_{{ $ah->id }}" value="{{ $ah->allotment->admission($sessn->id)->id }}">Undo</button>
                                            @else
                                                <button class="btn btn-primary btn-sm btn-admission" name="admit_{{ $ah->id }}" value="{{ $ah->allotment->id }}">Admit</button>
                                            @endif
                                        @endcan
                                        <a class="btn btn-secondary btn-sm" href="/allotment/{{ $ah->allotment->id }}/admission?back_link=/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}">detail</a>
                                    </div>
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


    $("button.btn-undo").click(function(){
        if(confirm("Are you sure you want to delete this admission?")){
            id = $(this).val();
            $.ajax({
                url : "/ajax/admission/" + $(this).val() + "/delete",
                type : "post",
                success : function(data,status){
                    alert(data);
                    location.reload();
                },
                error : function(){
                    alert("Error");
                }
            });

        }
    });

    $("input[name='find']").on("keyup", function() {
        var pattern = $(this).val();

        $("table tr").each(function(index) {
            if (index != 0) {
                $row = $(this);
                var text = $row.find("td.name").text().toLowerCase().trim();
                if(text.match(pattern)){
                    $(this).show();
                }
                else{
                    $(this).hide();
                }
            }
        });
    });
});
</script>
</x-layout>
