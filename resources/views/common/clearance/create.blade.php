<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Clearance form for leaving the hostel
                <p>
                    <a href="/allotment/{{ $cancel_seat->allotment_id }}" class="btn btn-secondary btn-sm">Student
                        info</a>
                </p>
            </x-slot>

            <form name="frm_submit" method="post" action="/cancelSeat/{{ $cancel_seat->id }}/clearance" onsubmit="return confirm('Are you sure?')">
                @csrf

                <div class="mb-3 form-group row">
                    <label for="name" class="col col-md-3">Name</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $cancel_seat->allotment->person->name) }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="rollno" class="col col-md-3">Rollno</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="rollno"
                            value="{{ old('rollno', $cancel_seat->allotment->person->student()->rollno) }}" required>
                        @error('rollno')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="course" class="col col-md-3">Course</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="course"
                            value="{{ old('course', $cancel_seat->allotment->person->student()->course) }}" required>
                        @error('course')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="department" class="col col-md-3">Department</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="department"
                            value="{{ old('department', $cancel_seat->allotment->person->student()->department) }}"
                            required>
                        @error('department')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="hostel" class="col col-md-3">Hostel</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="hostel"
                            value="{{ old('hostel', $cancel_seat->allot_hostel->hostel->name) }}" required>
                        @error('hostel')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="roomno" class="col col-md-3">Room No.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="roomno"
                        @if($cancel_seat->allot_seat)
                            value="{{ old('roomno', $cancel_seat->allot_seat->seat->room->roomno) }}" required>
                        @else
                            value="{{ old('roomno') }}" required>
                        @endif
                        @error('roomno')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="leave_dt" class="col col-md-3">Expected/Actual date of leaving</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" name="leave_dt"
                            value="{{ old('leave_dt', $cancel_seat->leave_dt) }}" required>
                        @error('leave_dt')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="issue_dt" class="col col-md-3">Data of issuance</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" name="issue_dt"
                            value="{{ old('issue_dt', date('Y-m-d')) }}" required>
                        @error('issue_dt')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="warden" class="col col-md-3">Warden</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="warden"
                            @if ($cancel_seat->allot_hostel->hostel->warden()) value="{{ old('warden', $cancel_seat->allot_hostel->hostel->warden()->person->name) }}" required>
                            @else
                                value="{{ old('warden') }}" required> @endif
                            @error('warden')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                            </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <div class="col col-md-3"></div>
                        <div class="col col-md-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
            </form>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $("div.student").hide();
            $("div.other").hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("input#available").click(function() {
                if ($(this).prop('checked')) {
                    $.ajax({
                        type: "get",
                        url: "/",
                        success: function(data, status) {
                            var s = "<option value='0'>Select Seat</option>";
                            for (i = 0; i < data.length; i++) {
                                s += "<option value='" + data[i].id + "'>Seat: " + data[i]
                                    .serial + " of " + data[i].roomno + "</option>";
                            }
                            $("select[id='seat']").html(s);
                            //alert(data[0].roomno);
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                } else {
                    load_seats();
                }
            });

        });
    </script>
</x-layout>
