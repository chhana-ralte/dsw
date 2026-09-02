<x-att-layout>
    <x-block>
        <x-slot name="heading">
            Attendance for {{ $attmaster->subject_code }} : {{ $attmaster->subject_name }}
            <p>
                <a class="btn btn-primary btn-sm" href="#">Create</a>
            </p>
        </x-slot>
        <form method="post" action="">
            @csrf
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Date of lecture
                </label>
                <div class="col col-md-6">
                    <input type="date" name='dt' class="form-control" value="{{ old('dt') }}" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    No of Hours
                </label>
                <div class="col col-md-6">
                    <select name='duration' class="form-control">
                        <option value="1" {{ old('duration')==1?'selected':'' }}>1 Hour</option>
                        <option value="2" {{ old('duration')==2?'selected':'' }}>2 Hours</option>
                        <option value="3" {{ old('duration')==3?'selected':'' }}>3 Hours</option>
                        <option value="4" {{ old('duration')==4?'selected':'' }}>4 Hours</option>
                    </select>
                </div>
            </div>
            @if(count($stds) > 0)
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <th>Rollno</th>
                        <th>Name</th>
                        <th>Marking</th>
                    </tr>
                    <?php $sl = 1 ?>
                    @foreach($stds as $std)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $std->rollno }}</td>
                            <td>{{ $std->name }}</td>
                            <td><input type="checkbox" name="marking[]" value="{{ $std->id }}"></td>
                        </tr>
                    @endforeach
                </table>
                <button type="submit" class="btn btn-primary">Submit</button>
            @else
                There is no student. Please enroll students by clicking <a href="/att/course/{{ $attmaster->course_id }}/sessn/{{ $attmaster->sessn_id }}/enroll/{{ $attmaster->semester }}">here</a>.
            @endif
        </form>
    </x-block>       
</x-att-layout>
