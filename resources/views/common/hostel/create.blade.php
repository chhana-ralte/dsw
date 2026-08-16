<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ __('Create new Hostel') }}
            </x-slot>

            <div style="width: 100%; overflow-x: auto; ;">
                <form method="post" action="/hostel">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="name" class="col col-md-6">
                            Name of Hostel
                        </label>
                        <div class="col col-md-6">
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="name" class="col col-md-6">
                            Gender
                        </label>
                        <div class="col col-md-6">
                            <select class="form-control" name='gender'>
                                <option disabled selected>Select hostel</option>
                                <option value="Male" {{ old('gender')=='Male'?'selected':''}}>Male</option>
                                <option value="Female" {{ old('gender')=='Female'?'selected':''}}>Female</option>
                            </select>
                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="name" class="col col-md-6">
                            Description
                        </label>
                        <div class="col col-md-6">
                            <textarea class="form-control" name='description'> {{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="name" class="col col-md-6">

                        </label>
                        <div class="col col-md-6">
                            <button class="btn btn-primary" type='submit'>Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </x-block>
    </x-container>
</x-layout>
