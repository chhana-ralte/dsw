<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                    Editing Seat: {{ $seat->serial }} of {{ $seat->room->roomno }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/seat/{{ $seat->id }}">back</a>
                </p>
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Edit
            </x-slot>
            <form method="post" action="/seat/{{$seat->id}}">
                @csrf
                @method('PUT')
                <div class="form-group row mb-3">
                    <label for="serial" class="col col-md-4">Serial</label>
                    <div class="col col-md-4">
                        <input type="text" name="serial" class="form-control" value="{{ old('serial',$seat->serial) }}">
                        <div class="invalid-feedback">
                            Should be numeric value
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="available" class="col col-md-4">Whether available for allocation?</label>
                    <div class="col col-md-4">
                        <input type="checkbox" name="available" {{ $seat->available?' checked ':''}}>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-4">

                    </div>
                    <div class="col col-md-4">
                        <button type="submit" class="btn btn-primary update">Update</button>
                    </div>
                </div>
            </form>
        </x-block>

    </x-container>

</x-layout>
