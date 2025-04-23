<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Registration of Student
            </x-slot>
            @if($user)
                <span class="text-danger">There is already user associated with the person</span>
            @else
                <form method="post" action="/studentRegistration/create_user_store">
                    @csrf
                    <input type="hidden" name="allotment" value="{{ $allotment->id }}">
                    <div class="form-group row mb-3">
                        <label for="name" class="col col-md-3">Name</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="name" value="{{ $allotment->person->name }}" disabled>
                        </div>
                    </div>
                    @if($student)
                        <div class="form-group row mb-3">
                            <label for="mzuid" class="col col-md-3">Mzu ID</label>
                            <div class="col col-md-4">
                                <input type="text" class="form-control" name="mzuid" value="{{ $student->mzuid }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="rollno" class="col col-md-3">Roll No.</label>
                            <div class="col col-md-4">
                                <input type="text" class="form-control" name="rollno" value="{{ $student->rollno }}" disabled>
                            </div>
                        </div>


                        <div class="form-group row mb-3">
                            <label for="course" class="col col-md-3">Course</label>
                            <div class="col col-md-4">
                                <input type="text" class="form-control" name="course" value="{{ $student->course }}" disabled>
                            </div>
                        </div>


                        <div class="form-group row mb-3">
                            <label for="department" class="col col-md-3">Department</label>
                            <div class="col col-md-4">
                                <input type="text" class="form-control" name="department" value="{{ $student->department }}" disabled>
                            </div>
                        </div>
                    @endif
                    <div>
                        <span class="text-secondary">Login information</span>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="username" class="col col-md-3">Select username</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="username" value="{{ old('username',$student->username) }}" required>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password" class="col col-md-3">Password</label>
                        <div class="col col-md-4">
                            <input type="password" class="form-control" name="password" value="" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password_confirmation" class="col col-md-3">Confirm password</label>
                        <div class="col col-md-4">
                            <input type="password" class="form-control" name="password_confirmation" value="" required>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col col-md-3">
                            
                        </div>
                        <div class="col col-md-4">
                            <button class="btn btn-primary btn-create" type="submit">Create</button>
                        </div>
                    </div>
                </form>
            @endif
        </x-block>

    </x-container>
</x-layout>
