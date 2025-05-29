<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Application form
                <p>
                    <a href="/application" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>

            <form name="frm_submit" method="post" action="/application/">
                @csrf

                <div class="mb-3 form-group row">
                    <label for="name" class="col col-md-3">Name</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="father" class="col col-md-3">Father/Guardian</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="father" value="{{ old('father') }}">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="mobile" class="col col-md-3">Mobile</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="email" class="col col-md-3">Email</label>
                    <div class="col col-md-4">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="category" class="col col-md-3">Category</label>
                    <div class="col col-md-4">
                        <select name='category' class='form-control'>
                            <option>Select Category</option>
                            <option value='General' {{ old('category') == 'General' ? ' selected ' : '' }}>General
                            <option value='OBC' {{ old('category') == 'OBC' ? ' selected ' : '' }}>OBC(NCL)</option>
                            <option value='SC' {{ old('category') == 'SC' ? ' selected ' : '' }}>SC</option>
                            <option value='ST' {{ old('category') == 'ST' ? ' selected ' : '' }}>ST</option>
                            <option value='EWS' {{ old('category') == 'EWS' ? ' selected ' : '' }}>EWS</option>
                            <option value='General'>General</option>
                            <option value='OBC' {{ old('category') == 'OBC' ? ' selected ' : '' }}>OBC(NCL)</option>
                            <option value='SC'>SC</option>
                            <option value='ST'>ST</option>
                            <option value='EWS'>EWS</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="state" class="col col-md-3">State</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="state" value="{{ old('state') }}">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="address" class="col col-md-3">Address</label>
                    <div class="col col-md-4">
                        <textarea class="form-control" name="address">{{ old('address', $person->address) }}</textarea>
                    </div>
                </div>
                <div class="mb-3 form-group row">
                    <label for="photo" class="col col-md-3">Photo</label>
                    <div class="col col-md-4">
                        <input type="file" class="form-control" name="photo">
                    </div>
                </div>
                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <img width="200px" src="{{ $person->photo }}" alt="" srcset="">
                    </div>
                </div>

                @if ($allotment->person->student())
                    <div class="mb-3 form-group row">
                        <label for="rollno" class="col col-md-3">Rollno</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="rollno"
                                value="{{ $allotment->person->student()->rollno }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="course" class="col col-md-3">Course</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="course"
                                value="{{ $allotment->person->student()->course }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="department" class="col col-md-3">Department*</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="department"
                                value="{{ $allotment->person->student()->department }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="mzuid" class="col col-md-3">MZU ID</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="mzuid"
                                value="{{ $allotment->person->student()->mzuid }}" disabled>
                        </div>
                    </div>
                @elseif($allotment->person->other())
                    <div class="mb-3 form-group row">
                        <label for="remark" class="col col-md-3">Remark*</label>
                        <div class="col col-md-4">
                            <textarea class="form-control" name="remark" disabled>{{ $allotment->person->other()->remark }}</textarea>
                        </div>
                    </div>
                @endif
                <div class="mb-3 form-group row">
                    <label for="hostel" class="col col-md-3">Hostel allotted</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mzuid"
                            value="{{ $allotment->hostel->name }}" disabled>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <label for="admitted">Admission done?</label>
                        <input type="checkbox" name="admitted" id="admitted">
                    </div>
                </div>

                <div class="mb-2 form-group row">
                    <div class="col col-md-3">
                        <label for="seat">Seat No.:</label>
                    </div>
                    <div class="col col-md-4">
                        <select class="form-control" id="seat" name="seat">

                        </select>
                        <input class="form-check-input" type="checkbox" value="1" id="available">
                        <label class="form-check-label" for="available">
                            Show only available rooms/seats
                        </label>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary submit">Admit</button>
                        <button type="button" class="btn btn-danger decline">Decline</button>

                    </div>
                </div>

            </form>
            <form method="post" name="frm_decline" action="/allotment/{{ $allotment->id }}/admission_decline">
                @csrf
            </form>
        </x-block>
    </x-container>
    <script>
        function load_seats() {
            $.ajax({
                type: "get",
                url: "/ajax/get_all_seats?hostel_id={{ $allotment->hostel->id }}",
                success: function(data, status) {
                    var s = "<option value='0'>Select Seat</option>";
                    for (i = 0; i < data.length; i++) {
                        s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i]
                            .roomno + "</option>";
                    }
                    $("select[id='seat']").html(s);
                    //alert(data[0].roomno);
                },
                error: function() {
                    alert("Error");
                }
            });
        }
        load_seats();

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
                        url: "/ajax/get_available_seats?hostel_id={{ $allotment->hostel->id }}",
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

            $("button.submit").click(function() {

                if ($("select#seat").val() != 0) {
                    $("form[name='frm_submit']").submit();
                } else {
                    alert("Make sure the seat is selected")
                }
            });

            $("button.decline").click(function() {
                if (confirm("Are you sure the student won't do admission?")) {
                    $("form[name='frm_decline']").submit();
                    alert("asdasds");
                }
            });
        });
    </script>
</x-layout>
