<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Application search
            </x-slot>
            <form name="frm_search" method="post" action="/appl/search">
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
                            <th>Programme</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($applications as $app)
                            <tr>
                                <td>
                                    <a href="/appl/{{ $app->id }}">{{ $app->name }}</a>
                                </td>
                                <td>
                                    {{  $app->course }}
                                </td>
                                <td>
                                    @if($app->status)
                                        {{ $app->status }}
                                    @else
                                        <span class="text-danger">No status</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @can('manage', $app)
                                            <a href="/application/{{ $app->id }}/edit?mzuid={{ $app->mzuid }}" class="btn btn-primary">Edit</a>
                                        @endcan
                                        @can('delete', $app)
                                            <a href="/application/{{ $app->id }}/delete" class="btn btn-danger">Delete</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </x-block>
        </x-container>

    @elseif(isset($str) && $str != '')
        <x-container>
            <x-block>
                <x-slot name="heading">
                    <h3 class="text-danger">No application found.</h3>
                </x-slot>
            </x-block>
        </x-container>
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
