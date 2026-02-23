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
                                    <button class="btn btn-sm btn-secondary">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
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
