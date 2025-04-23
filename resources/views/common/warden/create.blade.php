<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Warden details entry
                <p>
                    <a href="/hostel/{{ $hostel->id }}" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>                
            <form method="post" action="/hostel/{{ $hostel->id }}/warden">
                @csrf
                <div>
                    <div class="form-group row mb-3">
                        <div class="col col-md-4">
                            Name of Warden
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                    </div>


                    <div class="mb-3 form-group row">
                        <label for="mobile" class="col col-md-4">Mobile</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="mobile"
                                value="{{ old('mobile') }}" required>
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
    
                    <div class="mb-3 form-group row">
                        <label for="email" class="col col-md-4">Email</label>
                        <div class="col col-md-4">
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <div class="col col-md-4">
                            Hostel
                        </div>
                        <div class="col col-md-4">
                            <select name="hostel_id" class="form-control" required>
                                @foreach(\App\Models\Hostel::orderBy('name')->get() as $h)
                                    <option value="{{ $h->id }}" {{ $h->id==$hostel->id?' selected ':''}}>{{ $h->name }}</option>
                                @endforeach
                            </select>
                            @error('hostel_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="from_dt" class="col col-md-4">Appointment from</label>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="from_dt"
                                value="{{ old('from_dt') }}">
                                @error('from_dt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="to_dt" class="col col-md-4">Appointment upto</label>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="to_dt"
                                value="{{ old('to_dt') }}" required>
                                @error('to_dt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <div class="col col-md-4">
                            
                        </div>
                        <div class="col col-md-4">
                            <input type="checkbox" name="valid" id="valid" value="1" {{ old('valid')?' checked ':'' }}>
                            <label for="valid" class="col col-md-4">Current warden?</label>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                        </div>
                        <div class="col col-md-4">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>



        </x-block>
    </x-container>
</x-layout>
