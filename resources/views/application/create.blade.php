<x-layout>
    <x-container>
        @if(Session::has('exists'))
            <x-block>
                <span class="text-danger">There is already an application matching your detail, click <a href="/application/search">here</a> to search and manage your application.</span>
            </x-block>
        @endif
        <x-block>
            <x-slot name="heading">
                Application form
                <p>
                    <a
                        href="/application"
                        class="btn btn-secondary btn-sm"
                    >Back</a>
                </p>

            </x-slot>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                class="col-md-7"
                name="frm_submit"
                method="post"
                action="/application/"
                enctype="multipart/form-data"
            >
                @csrf
                <input type="hidden" name="ready" value="{{ Session::has('ready')?"1":"0" }}">
                @if(Session::has('ready'))
                    <input type="hidden" name="department" value="{{ old('department') }}">
                    <input type="hidden" name="course" value="{{ old('course') }}">
                    <input type="hidden" name="semester" value="{{ old('semester') }}">
                @endif
                <div class="mb-3 form-group row">
                    <label
                        for="name"
                        class="col-md-5"
                    >Name*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your name"
                            required
                        >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="father"
                        class="col-md-5"
                    >Father/Guardian*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="father"
                            value="{{ old('father') }}"
                            placeholder="Father/Guardian's name"
                            required
                        >
                        @error('father')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="dob"
                        class="col-md-5"
                    >Date of Birth*</label>
                    <div class="col-md-7">
                        <input
                            type="date"
                            class="form-control"
                            name="dob"
                            value="{{ old('dob') }}"
                            required
                        >
                        @error('dob')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="married"
                        class="col-md-5"
                    >Whether single/married?</label>
                    <div class="col-md-7">
                        <input
                            type="radio"
                            name="married"
                            id="married-no"
                            value="0"
                            {{ old('married')==0?' checked ':''}}
                        ><label for="married-no">Single/Divorced</label>
                        <input
                            type="radio"
                            name="married"
                            id="married-yes"
                            value="1"
                            {{ old('married')==1?' checked ':''}}
                        ><label for="married-yes">Married</label>
                        @error('married')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="gender"
                        class="col-md-5"
                    >Gender*</label>
                    <div class="col-md-7">
                        <select
                            name='gender'
                            class='form-control'
                            required
                        >
                            <option disabled selected>Select Gender</option>
                            <option
                                value='Male'
                                {{
                                old('gender')=='Male'
                                ? ' selected '
                                : ''
                                }}
                            >Male</option>
                            <option
                                value='Female'
                                {{
                                old('gender')=='Female'
                                ? ' selected '
                                : ''
                                }}
                            >Female</option>
                            <option
                                value='Other'
                                {{
                                old('gender')=='Other'
                                ? ' selected '
                                : ''
                                }}
                            >Other</option>
                        </select>
                         @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="mobile"
                        class="col-md-5"
                    >Mobile*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="mobile"
                            value="{{ old('mobile') }}"
                            placeholder="10 digit mobile number"
                            required
                        >
                        @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="email"
                        class="col-md-5"
                    >Email*</label>
                    <div class="col-md-7">
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Your email"
                            required
                        >
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="category"
                        class="col-md-5"
                    >Category*</label>
                    <div class="col-md-7">
                        <select
                            name='category'
                            class='form-control'
                            placeholder="Category"
                            required
                        >
                            <option disabled selected>Select Category</option>
                            <option
                                value='General'
                                {{
                                old('category')=='General'
                                ? ' selected '
                                : ''
                                }}
                            >General
                            <option
                                value='OBC'
                                {{
                                old('category')=='OBC'
                                ? ' selected '
                                : ''
                                }}
                            >OBC</option>
                            <option
                                value='OBC(NCL)'
                                {{
                                old('category')=='OBC(NCL)'
                                ? ' selected '
                                : ''
                                }}
                            >OBC(NCL)
                            </option>
                            <option
                                value='SC'
                                {{
                                old('category')=='SC'
                                ? ' selected '
                                : ''
                                }}
                            >SC</option>
                            <option
                                value='ST'
                                {{
                                old('category')=='ST'
                                ? ' selected '
                                : ''
                                }}
                            >ST</option>
                            <option
                                value='EWS'
                                {{
                                old('category')=='EWS'
                                ? ' selected '
                                : ''
                                }}
                            >EWS</option>
                        </select>
                        @error('category')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="PWD"
                        class="col-md-5"
                    >Whether Person with disability (PWD)?</label>
                    <div class="col-md-7">
                        <input
                            type="radio"
                            name="PWD"
                            id="PWD-yes"
                            value="1"
                            {{ old('PWD')==1?' checked ':''}}
                        ><label for="PWD-yes">Yes</label>
                        <input
                            type="radio"
                            name="PWD"
                            id="PWD-no"
                            value="0"
                            {{ old('PWD')==0?' checked ':''}}
                        ><label for="PWD-no">No</label>
                        @error('PWD')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="state"
                        class="col-md-5"
                    >State*</label>
                    <div class="col-md-7">
                        <input
                            class="form-control"
                            list="statelist"
                            id="state"
                            name="state"
                            value="{{ old('state') }}"
                            placeholder="Select your home State"
                            required
                        >
                        <datalist id="statelist">
                            @foreach(App\Models\State::list() as $key => $value)
                                <option value="{{ $value }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="address"
                        class="col-md-5"
                    >Address*</label>
                    <div class="col-md-7">
                        <textarea
                            class="form-control"
                            name="address"
                            placeholder="Your permanent address"
                            required
                        >{{ old('address') }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="AMC"
                        class="col-md-5"
                    >Whether in Aizawl Municipal Area?</label>
                    <div class="col-md-7">
                        <input
                            type="radio"
                            name="AMC"
                            id="AMC-yes"
                            value="1"
                            {{ old('AMC')==1?' checked ':''}}
                        ><label for="AMC-yes">Yes</label>
                        <input
                            type="radio"
                            name="AMC"
                            id="AMC-no"
                            value="0"
                            {{ old('AMC')==0?' checked ':''}}
                        ><label for="AMC-no">No</label>
                        @error('AMC')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="emergency"
                        class="col-md-5"
                    >Emergency Contact number*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="emergency"
                            value="{{ old('emergency') }}"
                            placeholder="Emergency number of/or parents contact"
                            required
                        >
                        @error('emergency')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="photo"
                        class="col-md-5"
                    >Passport size photo/ Selfie</label>
                    <div class="col-md-7">
                        <input
                            type="file"
                            class="form-control"
                            name="photo"
                            value="{{ old('photo') }}"
                            placeholder="Passport size/selfie"
                        >
                        @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="rollno"
                        class="col-md-5"
                    >Rollno</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="rollno"
                            value="{{ old('rollno') }}"
                            placeholder="Roll number (if assigned)"
                        >
                        @error('rollno')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
{{--
                <div class="mb-3 form-group row">
                    <label
                        for="department*"
                        class="col-md-5"
                    >Department/Centre*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="department"
                            value="{{ old('department') }}"
                            placeholder="Department (e.g., Psychology, Sociology, Zoology etc)"
                            required
                        >
                        @error('department')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
--}}
                <div class="mb-3 form-group row">
                    <label
                        for="department*"
                        class="col-md-5"
                    >Department/Centre*</label>
                    <div class="col-md-7">
                        <select
                            class="form-control"
                            name="department"
                            required
                        >
                            <option disabled selected>Select Department/Centre</option>
                            @foreach (App\Models\Department::orderBy('name')->get() as $dept)
                                <option value="{{ $dept->id }}" {{ old('department')==$dept->name?' selected ':''}}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
{{--
                <div class="mb-3 form-group row">
                    <label
                        for="course"
                        class="col-md-5"
                    >Course/Programme*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="course"
                            value="{{ old('course') }}"
                            placeholder="Course of study (e.g., M.A(History), M.Sc(Physics), B.Tech(IT) etc)"
                            required
                        >
                        @error('course')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
--}}
                <div class="mb-3 form-group row">
                    <label
                        for="course"
                        class="col-md-5"
                    >Course/Programme*</label>
                    <div class="col-md-7">
                        <select
                            class="form-control"
                            name="course"
                            required
                        >
                        </select>
                        @error('course')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="semester"
                        class="col-md-5"
                    >Semester* (Next session i.e., 2025-26)</label>
                    <div class="col-md-7">
                        <Select
                            class="form-control"
                            name="semester"
                            required
                        >
                    </select>
                        @error('semester')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="mzuid"
                        class="col-md-5"
                    >MZU ID/Application number*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="mzuid"
                            value="{{ old('mzuid') }}"
                            placeholder="e.g., MZU250001234"
                            required
                        >
                        @error('mzuid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="percent"
                        class="col-md-5"
                    >Last exam percent obtained*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="percent"
                            value="{{ old('percent') }}"
                            placeholder="e.g., 74.5"
                            required
                        >
                        @error('percent')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="reason"
                        class="col-md-5"
                    >Reason</label>
                    <div class="col-md-7">
                        <textarea
                            class="form-control"
                            name="reason"
                            placeholder="Reason for hostel requirement"
                        >{{ old('reason') }}</textarea>
                        @error('reason')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label class="col-md-5">Evaluate</label>
                    <div class="col-md-7">
                        <input type="text" name="first" value="{{ rand(5,20) }}" readonly size=1> +
                        <input type="text" name="second" value="{{ rand(5,20) }}" readonly size=1> + 1 =
                        <input type="text" name="result" size=2>
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label class="col-md-5"></label>
                    <div class="col-md-7">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#termsConditions">
                        Terms and conditions
                </button>
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">
                        <input type="checkbox" name="terms" id="terms">
                        <label for="terms">I read and agree all the terms and conditions.</label>
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">
                        <button
                            type="button"
                            class="btn btn-primary submit"
                        >Submit</button>
                    </div>
                </div>



            </form>
        </x-block>

        <div class="modal fade" id="termsConditions" tabindex="-1" aria-labelledby="termsConditionsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsConditionsLabel">Terms and conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Terms and conditions:
                    <ol>
                        <li>I shall always abide by the rules and regulations of the Mizoram University Hostel Manual.</li>
                        <li>I shall obey the authorities to take care of the hostels.</li>
                        <li>I shall not cook inside hostel room, and I shall avail whatever mess provided to me.</li>
                        <li>In the case of defaulting against the rules and regulations, I shall accept whatever action taken against me by the authority.</li>
                        <li>I shall not involve in any kind of ragging, fignting and violence.</li>
                        <li>I shall not damage the property in the hostel and I shall pay any fine imposed on me as a result.</li>
                        <li>I shall sign online undertaking regarding ragging if my application is granted.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
                </div>
            </div>
        </div>

    </x-container>
    <script>
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



            // $("button.submit").click(function() {
            //     if (confirm("Are you sure you want to submit?")) {
            //         $("form[name='frm_submit']").submit();
            //     }
            // });
        });
















    </script>
</x-layout>
