<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Semester fee demand portal

                <p>
                    <a href="/hostel/{{ $allot_hostel->hostel->id }}/semfee" class="btn btn-secondary btn-sm" >Back</a>
                </p>
            </x-slot>
            @if(count($semfees) > 0)
                <div style="width: 100%; overflo-x: auto">
                    <table class="table">
                        <tr>
                            <th>Session</th>
                            <th>Requested room type</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Update payment</th>
                        </tr>
                    @foreach($semfees as $sf)
                        <tr>
                            <td>{{ $sf->sessn->name() }}</td>
                            <td>{{ \App\Models\Room::room_type($sf->roomcapacity) }}</td>
                            <td>{{ $sf->status }}</td>
                            <td>
                                @can('manage', $sf)
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-secondary btn-edit" value="{{ $sf->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" value="{{ $sf->id }}">Delete</button>
                                </div>
                                @else
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-secondary" disabled>Edit</button>
                                    <button class="btn btn-sm btn-danger" disabled>Delete</button>
                                </div>
                                @endcan
                            </td>
                            <td>
                                @can("update_payment", $sf)
                                    @if($sf->status == "Sent")
                                        <button class="btn btn-sm btn-primary btn-update-payment-modal" value="{{ $sf->id }}">Update payment</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </div>
            @endif

        </x-block>
        <x-block>
            @if($semfee)
                Requirement for the semester {{ $semfee->sessn->name() }} has been submitted.
            @else
                Do you want to submit requirement for {{ $for_sessn->name() }}?
            @endif

        </x-block>

    </x-container>

    {{-- Modal for status update --}}

    <div class="modal fade" id="editSemfeeModal" tabindex="-1" aria-labelledby="editSemfeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSemfeeModalLabel">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" name='frmEdit'>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="semfee_id" value="">
                        <div class="mb-3">
                            <label for="sessn_id" class="col-form-label">Session:</label>
                            <select class="form-control" name="sessn_id">
                                @foreach(\App\Models\Sessn::all() as $sessn)
                                    <option id="sessn_{{ $sessn->id }}" value="{{ $sessn->id }}">{{ $sessn->name() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roomcapacity" class="col-form-label">Room type:</label>
                            <select class="form-control" name="roomcapacity">
                                <option id="room_1" value="1">Single</option>
                                <option id="room_2" value="2">Double</option>
                                <option id="room_3" value="3">Triple</option>
                                <option id="room_4" value="4">Dorm</option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="status" class="col-form-label">Status:</label>
                            <select class="form-control" name="status">
                                <option id="None" value="None">None</option>
                                <option id="Forwarded" value="Forwarded">Forwarded</option>
                                <option id="Sent" value="Sent">Sent</option>
                                <option id="Paid" value="Paid">Paid</option>
                                <option id="Cancelled" value="Cancelled">Cancelled</option>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal for status update --}}

    {{-- Modal for payment update --}}

    <div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePaymentModalLabel">Update Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" name='frmUpdatePayment' id='frmUpdatePayment'>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="semfee_id" value="">
                        <div class="mb-3">
                            <label for="sessn_id" class="col-form-label">Session:</label>
                            <input name="sessn_id" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="roomcapacity" class="col-form-label">Room type:</label>
                            <input name="roomcapacity" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ref" class="col-form-label">Reference no.:</label>
                            <input type="text" name="ref" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="payment_amt" class="col-form-label">Payment amount:</label>
                            <input type="number" name="payment_amt" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_dt" class="col-form-label">Payment date:</label>
                            <input type="date" name="payment_dt" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-update-payment">Update Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal for payment update --}}

    <script>
        function validate(){

            if($("select[name='capacity']").val() > 0)
                return true;
            else{

                alert("Please select the room type");
                return false;
            }
        }
        $(document).ready(function() {
            if($("input[name='ready']").val() == 1){

                $("form[name='frm_submit']").submit();
            }

            $("div.student").hide();
            $("div.other").hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-edit").click(function(){
                $.ajax({
                    type : 'get',
                    url : '/ajax/semfee/' + $(this).val() + '/getDetail',
                    success : function(data, status){
                        // alert(data.id);
                        $("select[name='sessn_id'] option#sessn_" + data.sessn_id).prop('selected','true');
                        $("select[name='roomcapacity'] option#room_" + data.roomcapacity).prop('selected','true');
                        $("select[name='status'] option#" + data.status).prop('selected','true');
                        $("input[name='status']").val(data.status);
                        $("#editSemfeeModal").modal("show");
                    },
                    error : function(){
                        alert('error occured');
                    }
                });

            });

            $("button.btn-update-payment-modal").click(function(){
                $.ajax({
                    type : 'get',
                    url : '/ajax/semfee/' + $(this).val() + '/getDetail',
                    success : function(data, status){
                        // alert(data.id);
                        $("input[name='semfee_id']").val(data.id);
                        $("input[name='sessn_id']").val(data.sessn_name);
                        $("input[name='roomcapacity']").val(data.room_type);

                        $("#updatePaymentModal").modal("show");
                    },
                    error : function(){
                        alert('error occured');
                    }
                });


            });
            $("button.btn-update-payment").click(function(){
                // alert("asdadsada");
                $("#frmUpdatePayment").attr('action', '/semfee/' + $("input[name='semfee_id']").val() + '/paymentUpdate');
                $("#frmUpdatePayment").submit();


            });

        });

    </script>
</x-layout>
