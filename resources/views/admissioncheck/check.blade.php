<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Check your admission status
            </x-slot>

            <form method="post" action="/admissioncheck">
                @csrf
                <div class="form-group row mb-3">
                    <label for="mzuid" class="col col-md-3">Mzu ID</label>
                    <div class="col col-md-4">
                        @if(isset($student))
                            <input type="text" class="form-control" name="mzuid" value="{{ old('mzuid',$student->mzuid) }}">
                        @else
                            <input type="text" class="form-control" name="mzuid" value="{{ old('mzuid') }}">
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="rollno" class="col col-md-3">Roll No.</label>
                    <div class="col col-md-4">
                        @if(isset($student))
                            <input type="text" class="form-control" name="rollno" value="{{ old('rollno',$student->rollno) }}">
                        @else
                            <input type="text" class="form-control" name="rollno" value="{{ old('rollno') }}">
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button class="btn btn-primary btn-create" type="submit">Search</update>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
    @if(isset($allotment))
        <x-container>
            <x-block>
                <x-slot name="heading">
                    Admission status of {{ $allotment->person->name }}
                </x-slot>
                @if(count($allotment->admissions) > 0)
                    <table class="table">
                        <tr>
                            <th>Session</th>
                            <th>Status</th>
                        </tr>
                        @foreach($allotment->admissions as $admission)
                        <tr>
                            <td>{{ $admission->sessn->name() }}</td>
                            <td>Done</td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <h4>No hostel admission record available</h4>
                @endif
            </x-block>
        </x-container>
    @endif

</x-layout>
