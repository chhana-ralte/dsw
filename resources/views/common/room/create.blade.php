<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Creating room in {{ $hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/room">back</a>
                </p>
            </x-slot>
            <form method="post" action="/hostel/{{$hostel->id}}/room">
                @csrf
                <div class="form-group row mb-3">
                    <label for="roomno" class="col col-md-4">Room No.</label>
                    <div class="col col-md-4">
                        <input type="text" name="roomno" class="form-control" value="{{ old('roomno') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="available" class="col col-md-4">Capacity</label>
                    <div class="col col-md-4">
                    <input type="text" name="capacity" class="form-control" value="{{ old('capacity') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="remark" class="col col-md-4">Any remark</label>
                    <div class="col col-md-4">
                        <textarea name="remark" class="form-control">{{ old('remark') }}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    
                    <div class="col col-md-4">
                        
                    </div>
                    <div class="col col-md-4">
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
</x-layout>
