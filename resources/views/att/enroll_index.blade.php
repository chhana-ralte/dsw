<x-att-layout>
    <x-block>
        <x-slot name="heading">
            Enrollment in the {{ $course->name }}
            @if($semester != 0)
                Semester : {{ $semester }}
            @endif
        </x-slot>
        Semester : 
        <div class="btn-group">
            @foreach($semesters as $sem)
            <a class="btn btn-outline-primary btn-sm" href="/att/course/{{ $course->id }}/sessn/{{ $sessn->id }}/enroll/{{ $sem->semester }}">{{ $sem->semester }}</a>
            @endforeach
        </div>
        @if(count($enrolls) > 0)
            <div style="width: 100%; overflow-x: auto">
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <th>Rollno</th>
                        <th>Name</th>
                        <th>Semester</th>
                    </tr>
                    <?php $sl=1 ?>
                    @foreach($enrolls as $er)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $er->std->rollno }}</td>
                            <td>{{ $er->std->name }}</td>
                            <td>{{ $er->semester }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </x-block>
    <x-block>
        <form method='post' action=''>
            @csrf
            <input type='hidden' name='course_id' value='{{ $course->id }}'>
            <input type='hidden' name='sessn_id' value='{{ $sessn->id }}'>
            <input type='hidden' name='semester' value='{{ $semester }}'>
            <div class="form-group row mb-3">
                <div class="col col-md-12">
                    <input type='text' name='rollno' class="form-control" placeholder='Enter Roll Number' required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col col-md-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </x-block>
</x-att-layout>
