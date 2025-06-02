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
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="father" class="col col-md-3">Father/Guardian</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="father" value="{{ old('father') }}" required>
                        @error('father')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="gender" class="col col-md-3">Gender</label>
                    <div class="col col-md-4">
                        <select name='gender' class='form-control'>
                            <option>Select Gender</option>
                            <option value='Male' {{ old('gender') == 'Male' ? ' selected ' : '' }}>Male</option>
                            <option value='Female' {{ old('gender') == 'Female' ? ' selected ' : '' }}>Female</option>
                            <option value='Other' {{ old('gender') == 'Other' ? ' selected ' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="mobile" class="col col-md-3">Mobile</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="email" class="col col-md-3">Email</label>
                    <div class="col col-md-4">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="category" class="col col-md-3">Category</label>
                    <div class="col col-md-4">
                        <select name='category' class='form-control' required>
                            <option>Select Category</option>
                            <option value='General' {{ old('category') == 'General' ? ' selected ' : '' }}>General
                            <option value='OBC' {{ old('category') == 'OBC' ? ' selected ' : '' }}>OBC</option>
                            <option value='OBC(NCL)' {{ old('category') == 'OBC(NCL)' ? ' selected ' : '' }}>OBC(NCL)
                            </option>
                            <option value='SC' {{ old('category') == 'SC' ? ' selected ' : '' }}>SC</option>
                            <option value='ST' {{ old('category') == 'ST' ? ' selected ' : '' }}>ST</option>
                            <option value='EWS' {{ old('category') == 'EWS' ? ' selected ' : '' }}>EWS</option>
                        </select>
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="state" class="col col-md-3">State</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="state" value="{{ old('state') }}" required>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="address" class="col col-md-3">Address</label>
                    <div class="col col-md-4">
                        <textarea class="form-control" name="address" required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="photo" class="col col-md-3">Photo</label>
                    <div class="col col-md-4">
                        <input type="file" class="form-control" name="photo">
                        @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="rollno" class="col col-md-3">Rollno</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="rollno" value="{{ old('rollno') }}" required>
                        @error('rollno')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="course" class="col col-md-3">Course</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="course" value="{{ old('course') }}"
                            required>
                        @error('course')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="department" class="col col-md-3">Department</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="department"
                            value="{{ old('department') }}" required>
                        @error('department')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="mzuid" class="col col-md-3">MZU ID</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mzuid" value="{{ old('mzuid') }}">
                        @error('mzuid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>




                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary submit">Submit</button>
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

            $("button.submit").click(function() {
                if (confirm("Are you sure you want to submit?")) {
                    $("form[name='frm_submit']").submit();
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
