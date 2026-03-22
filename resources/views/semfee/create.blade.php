<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Semester fee demand portal
                <p>
                    <a href="/semfee?hostel_id={{ $allot_hostel->hostel->id }}" class="btn btn-secondary btn-sm" >Back</a>
                </p>
            </x-slot>
            @if(count($semfees) > 0)
                <div>
                    <table class="table">
                        <tr>
                            <th>Session</th>
                            <th>Current room type</th>
                            <th>Status</th>
                            <th>Action</th>
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
                        </tr>
                    @endforeach
                </div>
            @endif
            @can('manage_semfee', $allot_hostel)
                <form class="col-md-7" name="frm_submit" method="post" action="/allot_hostel/{{ $allot_hostel->id }}/semfee" onsubmit="return validate();">
                    @csrf


                    <div class="mb-3 form-group row">
                        <label class="col-md-5">Session</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="sessn" readonly value="{{ $sessn->name() }}">
                            <input type='hidden' name='sessn_id' value="{{ $sessn->id }}">
                        </div>
                    </div>
                    <div class="mb-3 form-group row">
                        <label for="capacity" class="col-md-5">Room type</label>
                        <div class="col-md-7">
                            <select name='capacity' class='form-control' placeholder="Room type" required>
                                <option disabled selected>Select Room type</option>
                                <option value='1' {{ $capacity =='1' ? ' selected ' : '' }} >Single</option>
                                <option value='2' {{ $capacity =='2' ? ' selected ' : '' }} >Double</option>
                                <option value='3' {{ $capacity =='3' ? ' selected ' : '' }} >Triple</option>
                                <option value='4' {{ $capacity > 3 ? ' selected ' : '' }} >Dorm</option>
                            </select>
                            @error('capacity')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label class="col-md-5"></label>
                        <div class="col-md-7">
                            <button class="btn btn-primary" type="submit">Submit</button>

                        </div>
                    </div>

                </form>
            @endcan
        </x-block>

    </x-container>

    {{-- Modal for payment update --}}

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
                })

            });


            $("button.submit").click(function(){
                let first = parseInt($("input[name='first']").val());
                let second = parseInt($("input[name='second']").val());
                let result = first + second + 1;
                if(result != parseInt($("input[name='result']").val())){
                    alert("Fill the evaluation box correctly.");
                    $("input[name='result']").focus();
                    exit();
                }
                if(!$("input[name='terms']").prop('checked')){
                    alert("Make sure you agreed to the terms and conditions.");
                    $("input[name='terms']").focus();
                    exit();
                }
                $("form[name='frm_submit']").submit();
            });

            $("select[name='department']").change(function(){
                $.ajax({
                    type : 'get',
                    url : "/ajax/getCourses?department=" + $(this).val(),
                    success : function(data,status){
                        var s = "<option disabled selected>Select Course</option>";
                            for (i = 0; i < data.length; i++) {
                                s += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                            }
                            $("select[name='course']").html(s);
                    },
                    error : function(){
                        alert("Error");
                    },
                });
            });

            $("select[name='course']").change(function(){
                $.ajax({
                    type : 'get',
                    url : "/ajax/getMaxSem?course=" + $(this).val(),
                    success : function(data,status){
                        var s = "<option disabled selected>Select Semester</option>";
                            for (i = 1; i <= data.max_sem; i++) {
                                s += "<option value='" + i + "'>" + i + "</option>";
                            }
                            $("select[name='semester']").html(s);
                    },
                    error : function(){
                        alert("Error");
                    },
                });
            });

        });

    </script>
</x-layout>
