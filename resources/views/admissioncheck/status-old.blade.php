<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission status
            </x-slot>
        
            <form method="post" action="/admissioncheck">
                @csrf
                
                <div class="form-group row mb-3">
                    <label for="mzuid" class="col col-md-3">Mzuid*</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mzuid" value="{{ $allotment->person->student()->mzuid }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="rollno" class="col col-md-3">Roll No.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="rollno" value="{{ $allotment->person->student()->rollno }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button class="btn btn-primary btn-create" type="button" disabled>Search</update>
                    </div>
                </div>
            </form>
            @if(count(admissions) > 0)
                <table class="table">
                    <tr>
                        <th>Session</th>
                        <th>Status</th>
                    </tr>
                    @foreach($allotment->admissions as $admission)
                    <tr>
                        <td>{{ $admission->sessn->name() }}</td>
                        <td>{{ $admission->id }}</td>
                    </tr>
                    @endforeach
                </table>
            @else
                <h3>No hostel admission record available</h3>
            @endif
        </x-block>
    </x-container>
</x-layout>
