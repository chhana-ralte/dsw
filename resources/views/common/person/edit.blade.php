<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Editing personal info: {{ $person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Editing personal details
            </x-slot>
            <form method="post" action="/person/{{ $person->id }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type='hidden' name='back_link' value="{{ $back_link }}">
                <div class="mb-3 form-group row">
                    <label for="name" class="col col-md-3">Name</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $person->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="father" class="col col-md-3">Father/Guardian</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="father"
                            value="{{ old('father', $person->father) }}">
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
                            <option value='Male' {{ $person->gender == 'Male' ? ' selected ' : '' }}>Male</option>
                            <option value='Female' {{ $person->gender == 'Female' ? ' selected ' : '' }}>Female</option>
                            <option value='Other' {{ $person->gender == 'Other' ? ' selected ' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="mobile" class="col col-md-3">Mobile</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mobile"
                            value="{{ old('mobile', $person->mobile) }}">
                        @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="email" class="col col-md-3">Email</label>
                    <div class="col col-md-4">
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $person->email) }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="category" class="col col-md-3">Category</label>
                    <div class="col col-md-4">
                        <select name='category' class='form-control'>
                            <option>Select Category</option>
                            <option value='General' {{ $person->category == 'General' ? ' selected ' : '' }}>General
                            </option>
                            <option value='OBC' {{ $person->category == 'OBC' ? ' selected ' : '' }}>OBC</option>
                            <option value='SC' {{ $person->category == 'SC' ? ' selected ' : '' }}>SC</option>
                            <option value='ST' {{ $person->category == 'ST' ? ' selected ' : '' }}>ST</option>
                            <option value='EWS' {{ $person->category == 'EWS' ? ' selected ' : '' }}>EWS</option>
                        </select>
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="state" class="col col-md-3">State</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="state"
                            value="{{ old('state', $person->state) }}">
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label for="address" class="col col-md-3">Address</label>
                    <div class="col col-md-4">
                        <textarea class="form-control" name="address">{{ old('address', $person->address) }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
                        <img width="200px" src="{{ $person->photo }}" alt="Not Available" srcset="">
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <a class="btn btn-secondary" href="{{ $back_link }}">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="update">Update</update>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button#unavailable").click(function() {
                $("form#unavailabl").submit();
            });

            $("a.deallocate").click(function() {
                if (confirm("Are you sure you want to deallocate this student from the existing seat?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/seat/" + $(this).attr("id") + "/deallocate",

                        success: function(data, status) {
                            if (data == "Success") {
                                alert("Deallocation successful");
                                location.replace("/person/{{ $person->id }}");
                            }
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }
                //alert($(this).attr('id'));
            });
        });
    </script>
</x-layout>
