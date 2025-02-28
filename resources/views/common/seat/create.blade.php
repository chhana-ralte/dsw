<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Creating seat in {{ $room->roomno }} of {{ $room->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}/seat">back</a>
                </p>
            </x-slot>
            <form method="post" action="/room/{{$room->id}}/seat">
                @csrf
                <div class="form-group row mb-3">
                    <label for="serial" class="col col-md-4">Serial</label>
                    <div class="col col-md-4">
                        <input type="text" name="serial" class="form-control" value="{{ old('serial') }}">
                        <div class="invalid-feedback">
                            Should be numeric value
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="available" class="col col-md-4">Whether available for allocation?</label>
                    <div class="col col-md-4">
                        <input type="checkbox" name="available" checked>
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
