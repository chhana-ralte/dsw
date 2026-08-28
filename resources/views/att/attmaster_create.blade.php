<x-appl-layout>
    <x-block>
        <x-slot name="heading">
            Create master subject
        </x-slot>
        <form method="post" action="/att/attmaster">
            @csrf
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Select the Course
                </label>
                <div class="col col-md-6">
                    <select name='course' class="form-control">
                        @foreach($courses as $crs)
                            <option value="{{ $crs->id }}">{{ $crs->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Select the Session
                </label>
                <div class="col col-md-6">
                    <select name='sessn' class="form-control">
                        @foreach($sessns as $ssn)
                            <option value="{{ $ssn->id }}" {{ $ssn->id==App\Models\Sessn::current()->id?'selected':''}}>
                                {{ $ssn->name() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Select the Subject code
                </label>
                <div class="col col-md-6">
                    <input type='text' class='form-control' name='subject_code'>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col col-md-6">
                    Select the Subject code
                </label>
                <div class="col col-md-6">
                    <input type='text' class='form-control' name='subject_name'>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col col-md-6">

                </label>
                <div class="col col-md-6">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </x-block>
</x-appl-layout>
