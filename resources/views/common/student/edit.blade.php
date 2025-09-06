<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Editing student's info for: {{ $student->person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Student's details
            </x-slot>
            <form method="post" action="/student/{{ $student->id }}">
                @csrf
                @method('PUT')
                <input type='hidden' name='back_link' value="{{ $back_link }}">
                <div class="form-group row mb-3">
                    <label for="rollno" class="col col-md-3">Rollno</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="rollno" value="{{ old('rollno',$student->rollno) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="course" class="col col-md-3">Course</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="course" value="{{ old('course',$student->course) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="department" class="col col-md-3">Department</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="department" value="{{ old('department',$student->department) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="mzuid" class="col col-md-3">MZU ID</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mzuid" value="{{ old('mzuid',$student->mzuid) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
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
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });
});
</script>
</x-layout>
