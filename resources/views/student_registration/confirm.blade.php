<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Registration of Student
            </x-slot>
            
            <form method="post" action="/studentRegistration">
                @csrf
                
                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Name of student</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ $student->person->name }}" disabled>
                    </div>
                </div>

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


                <div class="form-group row mb-3">
                    <div class="col col-md-3">
                        Please confirm if this is you
                    </div>
                    <div class="col col-md-4">
                        <a class="btn btn-danger btn-sm" href="/studentRegistration">No</a>
                        <a class="btn btn-primary btn-sm btn-create" href="/studentRegistration/create_user?allotment={{ $allotment->id }}">Confirm</a>
                    </div>
                </div>
            </form>
        </x-block>

    </x-container>
</x-layout>
