<x-layout>
    <x-container>
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

            <form
                name="frm_submit"
                method="post"
                action="/application/"
                enctype="multipart/form-data"
                onsubmit="return confirm('Are you sure you want to submit?')"
            >
                @csrf

                <div class="mb-3 form-group row">
                    <label
                        for="name"
                        class="col col-md-3"
                    >Name*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Father/Guardian*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Date of Birth*</label>
                    <div class="col col-md-4">
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
                        for="gender"
                        class="col col-md-3"
                    >Gender*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Mobile*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Email*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Category*</label>
                    <div class="col col-md-4">
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
                        for="state"
                        class="col col-md-3"
                    >State*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Address*</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Whether in Aizawl Municipal Area?</label>
                    <div class="col col-md-4">
                        <input
                            type="checkbox"
                            name="AMC"
                            id="AMC"
                            value="1"
                            {{ old('AMC')?' checked ':''}}
                        ><label for="AMC">(Check if yes)</label>
                        @error('AMC')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="photo"
                        class="col col-md-3"
                    >Passport size photo/ Selfie</label>
                    <div class="col col-md-4">
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
                        class="col col-md-3"
                    >Rollno</label>
                    <div class="col col-md-4">
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

                <div class="mb-3 form-group row">
                    <label
                        for="course"
                        class="col col-md-3"
                    >Course/Programme</label>
                    <div class="col col-md-4">
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

                <div class="mb-3 form-group row">
                    <label
                        for="department"
                        class="col col-md-3"
                    >Department/Centre</label>
                    <div class="col col-md-4">
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

                <div class="mb-3 form-group row">
                    <label
                        for="semester"
                        class="col col-md-3"
                    >Semester</label>
                    <div class="col col-md-4">
                        <Select
                            class="form-control"
                            name="semester"
                            required
                        >
                        <option disabled selected>Select Semester</option>
                        @for($i=1;$i<=10;$i++)
                            <option value="{{ $i }}" {{old('semester')==$i?' selected ':''}}>{{ $i }}</option>
                        @endfor
                    </select>
                        @error('semester')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="mzuid"
                        class="col col-md-3"
                    >MZU ID</label>
                    <div class="col col-md-4">
                        <input
                            type="text"
                            class="form-control"
                            name="mzuid"
                            value="{{ old('mzuid') }}"
                            placeholder="e.g., MZU250001234"
                        >
                        @error('mzuid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="percent"
                        class="col col-md-3"
                    >Last exam percent obtained</label>
                    <div class="col col-md-4">
                        <input
                            type="text"
                            class="form-control"
                            name="percent"
                            value="{{ old('percent') }}"
                            placeholder="e.g., 74.5"
                        >
                        @error('percent')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button
                            type="submit"
                            class="btn btn-primary submit"
                        >Submit</button>
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

            $("form[name='frm_submit']").onsubmit(function(){
                if(confirm("Are you sure")){
                    alert("hehe");
                }
            });

            // $("button.submit").click(function() {
            //     if (confirm("Are you sure you want to submit?")) {
            //         $("form[name='frm_submit']").submit();
            //     }
            // });

            $("button.decline").click(function() {
                if (confirm("Are you sure the student won't do admission?")) {
                    $("form[name='frm_decline']").submit();
                    alert("asdasds");
                }
            });
        });
















    </script>
</x-layout>
