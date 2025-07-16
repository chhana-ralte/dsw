<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Add to existing allotment
                <p>
                    <a
                        href="/application/{{ $application->id}}?mzuid={{ $application->mzuid }}"
                        class="btn btn-secondary btn-sm"
                    >Back</a>
                </p>

            </x-slot>

            <form
                class="col-md-7"
                name="frm_submit"
                method="post"
                action="/application/{{ $application->id}}/existing"
                onsubmit="return confirm('Are you sure you want to add this application to existing allotment?');"

            >
                @csrf
                @method('put')
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <div class="mb-3 form-group row">
                    <label
                        for="name"
                        class="col-md-5"
                    >Name*</label>
                    <div class="col-md-7">
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ old('name',$application->name) }}"
                            placeholder="Name of student"
                            readonly
                        >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 form-group row">
                    <label
                        for="notification"
                        class="col-md-5"
                    >Existing notification*</label>
                    <div class="col-md-7">
                        <select
                            name='notification'
                            class='form-control'
                            required
                        >
                            <option disabled selected>Select notification</option>
                            @foreach($notifications as $noti)
                            <option value='{{ $noti->id }}' {{ old('notification')==$noti->id ? ' selected ' : '' }}>
                                {{ $noti->no }}
                            </option>
                            @endforeach
                        </select>
                        @error('notification')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="from_dt"
                        class="col-md-5"
                    >From*</label>
                    <div class="col-md-7">
                        <input
                            type="date"
                            class="form-control"
                            name="from_dt"
                            value="{{ old('from_dt') }}"
                            required
                        >
                        @error('from_dt')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="to_dt"
                        class="col-md-5"
                    >To*</label>
                    <div class="col-md-7">
                        <input
                            type="date"
                            class="form-control"
                            name="to_dt"
                            value="{{ old('to_dt') }}"
                            required
                        >
                        @error('to_dt')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="mb-3 form-group row">
                    <label
                        for="hostel"
                        class="col-md-5"
                    >Hostel allotted*</label>
                    <div class="col-md-7">
                        <select
                            name='hostel'
                            class='form-control'
                            required
                        >
                            <option disabled selected>Select hostel</option>
                            @foreach(App\Models\Hostel::orderBy('gender')->orderBy('name')->get() as $ht)
                            <option
                                value='{{ $ht->id }}'
                                {{
                                old('hostel')==$ht->id
                                ? ' selected '
                                : ''
                                }}
                            >{{ $ht->name }}</option>
                            @endforeach
                        </select>
                        @error('hostel')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div

                        class="col-md-5"
                    ></div>
                    <div class="col-md-7">
                        <input type="checkbox" name="delete_application" id="delete_application" value="1">
                        <label for="delete_application">Delete application?</label>

                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <div

                        class="col-md-5"
                    ></div>
                    <div class="col-md-7">
                        <button
                            type="submit"
                            class="btn btn-primary submit"
                        >Submit</button>
                    </div>
                </div>

            </form>
        </x-block>



    </x-container>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });



        });


    </script>
</x-layout>
