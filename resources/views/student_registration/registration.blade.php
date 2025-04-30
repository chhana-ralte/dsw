<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Registration of Student (Enter either your MZU ID or your Roll number)
            </x-slot>
            
            <form method="post" action="/studentRegistration">
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

        @if(isset($allotment))
            <x-block>
                <x-slot name="heading">
                    Allotment status of {{ $allotment->person->name }}
                </x-slot>
                <table class="table">
                    <tr>
                        <td>Allotment Notification and date:</td>
                        <td>{{ $allotment->notification->no }}, dated {{ $allotment->notification->dt }}</td>
                    </tr>
                </table>
            </x-block>
        @endif
    </x-container>
</x-layout>
