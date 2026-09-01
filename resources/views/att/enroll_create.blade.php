<x-att-layout>
    <x-block>
        <x-slot name="heading">
            Create master subject
        </x-slot>
        <form method="post" action="/att/course/{{ $course->id }}/sessn/{{ $sessn->id }}/enroll_store">
            @csrf
            <input type='hidden' name='std_id' value='{{ $std->id }}'>
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Roll number
                </label>
                <div class="col col-md-6">
                    <input name='rollno' class="form-control" value="{{ $std->rollno }}" readonly>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Name
                </label>
                <div class="col col-md-6">
                    <input type='text' class='form-control' name='name' value="{{ $std->name }}" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Phone
                </label>
                <div class="col col-md-6">
                    <input type='number' class='form-control' name='phone' value="{{ $std->phone }}">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    email
                </label>
                <div class="col col-md-6">
                    <input type='email' class='form-control' name='email' value="{{ $std->email }}">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Course/Programme
                </label>
                <div class="col col-md-6">
                    <input type='text' class='form-control' name='course' value="{{ $course->name }}" readonly>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Session
                </label>
                <div class="col col-md-6">
                    <input type='text' class='form-control' name='sessn' value="{{ $sessn->name() }}" readonly>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Semester
                </label>
                <div class="col col-md-6">
                    <select name='semester' class="form-control">
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}" {{ $semester == $i?'selected':'' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col col-md-6">

                </label>
                <div class="col col-md-6">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </x-block>
</x-att-layout>
