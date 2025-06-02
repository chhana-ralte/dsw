<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Allotment
                <p>
                    <a href="/notification/{{ $notification->id }}/allotment" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Personal information
            </x-slot>
            <form method="post" action="/notification/{{ $notification->id }}/allotment">
                <input type='hidden' name='selected'>
                @csrf
                {{-- Personal Information --}}
                <div class="mb-3 form-group row">
                    <label for="name" class="col col-md-3">Name*</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="father" class="col col-md-3">Father/Guardian</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="father" value="{{ old('father') }}">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="gender" class="col col-md-3">Gender</label>
                    <div class="col col-md-4">
                        <select name='gender' class='form-control'>
                            <option>Select Gender</option>
                            <option value='Male'>Male</option>
                            <option value='Female'>Female</option>
                            <option value='Other'>Other</option>
                        </select>
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
                            <option value='General'>General</option>
                            <option value='OBC'>OBC</option>
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
                        <textarea class="form-control" name="address">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label class="col col-md-3">Student or other?</label>
                    <div class="col col-md-4">
                        <button type="button" class="btn btn-primary btn-choice" id="btn-student">Student</button>
                        <button type="button" class="btn btn-primary btn-choice" id="btn-other">Other</button>
                    </div>
                </div>


                {{-- Student Information --}}
                <div class="student">
                    <div class="mb-3 form-group row">
                        <label for="rollno" class="col col-md-3">Rollno</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="rollno" value="{{ old('rollno') }}">
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="course" class="col col-md-3">Course</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="course" value="{{ old('course') }}">
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="department" class="col col-md-3">Department*</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="department"
                                value="{{ old('department') }}">
                        </div>
                    </div>


                    <div class="mb-3 form-group row">
                        <label for="mzuid" class="col col-md-3">MZU ID</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="mzuid" value="{{ old('mzuid') }}">
                        </div>
                    </div>
                </div>




                {{-- Other Information --}}
                <div class="other">
                    <div class="mb-3 form-group row">
                        <label for="remark" class="col col-md-3">Remark*</label>
                        <div class="col col-md-4">
                            <textarea class="form-control" name="remark">{{ old('remark') }}</textarea>
                        </div>
                    </div>
                </div>


                {{-- Hostel Information --}}
                <div class="mb-3 form-group row">
                    <label for="hostel" class="col col-md-3">Hostel*</label>
                    <div class="col col-md-4">
                        <select name='hostel' class='form-control' required>
                            <option value=0>Select Hostel</option>
                            @foreach (\App\Models\Hostel::orderBy('name')->get() as $h)
                                <option value='{{ $h->id }}'>{{ $h->name }} ({{ $h->gender }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="from_dt" class="col col-md-3">Allotment from*</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" name="from_dt" value="{{ old('from_dt') }}"
                            required>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="to_dt" class="col col-md-3">To*</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" name="to_dt" value="{{ old('to_dt') }}"
                            required>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button class="btn btn-primary btn-create" type="button">Create</update>
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

            $("button.btn-choice").click(function() {
                if ($(this).attr('id') == 'btn-student') {
                    $(this).prop('disabled', true);
                    $("button#btn-other").prop('disabled', false);
                    $("input[name='selected']").val("student");

                    $("div.student").show();
                    $("div.other").hide();

                } else {
                    $(this).prop('disabled', true);
                    $("button#btn-student").prop('disabled', false);
                    $("input[name='selected']").val("other");

                    $("div.student").hide();
                    $("div.other").show();
                }
            });

            $("button.btn-create").click(function() {
                if ($("select[name='hostel']").val() == 0) {
                    alert("Select the hostel");
                    exit();
                } else if (!$("input[name='selected']").val()) {
                    if (!confirm(
                            "Are you sure you want to continue without choosing whether the person is whether student or not?"
                            )) {
                        exit();
                    }
                } else if ($("input[name='selected']").val() == "student" && ($("input[name='department']")
                        .val() == "")) {
                    alert("Fill up the required field under student info");
                    exit();
                } else if ($("input[name='selected']").val() == "other" && ($("textarea[name='remark']")
                        .val() == "")) {
                    alert($("textarea[name='remark']").val());
                    alert("Fill up the required field under other info");
                    exit();
                }
                $("form").submit();
            });
        });
    </script>
</x-layout>
