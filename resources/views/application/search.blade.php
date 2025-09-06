<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Application search
                <p>
                    <a href="/application" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>

            <form
                name="frm_search"
                method="post"
                action="/application/search"
            >
                @csrf
                <input type="hidden" name="type" value="mzuid">
                <div class="mb-3 form-group row">
                    <label
                        for="dob"
                        class="col col-md-4"
                    >Date of Birth*</label>
                    <div class="col col-md-4">
                        <input
                            type="date"
                            class="form-control"
                            name="dob"
                            value="{{ old('dob',isset($application)?$application->dob:'') }}"
                            required
                        >
                        @error('dob')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        for="mzuid"
                        class="col col-md-4"
                    >MZU ID/Application number*</label>
                    <div class="col col-md-4">
                        <input
                            type="text"
                            class="form-control"
                            name="mzuid"
                            value="{{ old('mzuid',isset($application)?$application->mzuid:'') }}"
                            placeholder="e.g., MZU250001234"
                            required
                        >
                        @error('mzuid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 form-group row">
                    <div class="col col-md-4"></div>
                    <div class="col col-md-4">
                        <button
                            type="submit"
                            class="btn btn-primary submit"
                        >Search</button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>

    @can('manages', App\Models\Application::class)

        <x-container>
            <x-block>
                <x-slot name="heading">
                    Application search
                </x-slot>

                <form name="frm_search" method="post" action="/application/search">
                    @csrf
                    <input type="hidden" name="type" value="str">

                    <div class="mb-3 form-group row">
                        <label for="dob" class="col col-md-4">Enter partial search string</label>
                        <div class="col col-md-4">
                            <input type="text" class="form-control" name="str" value="{{ old('dob',isset($str)?$str:'') }}" required>
                        </div>
                    </div>
                    <div class="mb-3 form-group row">
                        <div class="col col-md-4"></div>
                        <div class="col col-md-4">
                            <button type="submit" class="btn btn-primary submit">Search</button>
                        </div>
                    </div>
                </form>
            </x-block>
        </x-container>

    @endcan

    @if(isset($application))
        <x-container>
            <x-block>
                <x-slot name="heading">
                    Application details
                </x-slot>
                <div class="mb-3 form-group row">
                    <label
                        for="name"
                        class="col col-md-4"
                    >Name</label>
                    <div class="col col-md-4">
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ $application->name }}"
                            placeholder="Your name"
                            readonly
                        >
                    </div>
                </div>

                <div class="mb-3 form-group row">
                    <label
                        class="col col-md-4"
                    >Status</label>
                    <div class="col col-md-4">
                        <input
                            type="text"
                            class="form-control"
                            name="status"
                            value="{{ $application->status }}"
                            placeholder="Your name"
                            readonly
                        >
                    </div>
                </div>
                @if($application->remark)
                    <div class="mb-3 form-group row">
                        <label
                            class="col col-md-4"
                        >Remark</label>
                        <div class="col col-md-4">
                            <textarea
                                class="form-control"

                                placeholder="Your name"
                                readonly
                            >{{ $application->remark }}</textarea>
                        </div>
                    </div>
                @endif
                <div class="mb-3 form-group row">
                    <div class="col col-md-4"></div>
                    <div class="col col-md-4">
                        <a href="/application/{{ $application->id }}?mzuid={{ $application->mzuid }}"

                            class="btn btn-primary"
                        >View application details</a>
                    </div>
                </div>
            </x-block>
        </x-container>

    @elseif($mzuid != '')
        <span class="text-danger">No application found.</span>
    @endif

    @if(isset($applications))

        <x-container>
            <x-block>
                <x-slot name="heading">
                    Application details
                </x-slot>
                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($applications as $app)
                            <tr>
                                <td>

                                    <a href="/application/{{ $app->id }}?mzuid={{ $app->mzuid }}">{{ $app->name }}</a>

                                </td>
                                <td>
                                    @if($app->status)
                                        {{ $app->status }}
                                    @else
                                        <span class="text-danger">No status</span>
                                    @endif
                                </td>
                                <td>
                                    @can('manage', $app)
                                        <a href="/application/{{ $app->id }}/edit?mzuid={{ $app->mzuid }}" class="btn btn-primary">Edit</a>
                                    @endcan
                                    @can('delete', $app)
                                        <a href="/application/{{ $app->id }}/delete" class="btn btn-danger">Delete</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </x-block>
        </x-container>

    @elseif(isset($str) && $str != '')
        <span class="text-danger">No application found.</span>
    @endif




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
