<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Interdisciplinary Course Selection portal
            </x-slot>

        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <form id="frmEntry" method="get" action="/diktei/entry">
                <div class="mb-3">
                    <label for="mzuid" class="col-form-label">Enter your MZU ID (Application Form Number)/ Roll
                        number</label>
                    <input class="form-control" name="mzuid" placeholder="e.g., MZU0000012345, MZUC000yyyyyy" required
                        value="{{ $mzuid }}">
                </div>
                <button type="submit" class="submit-btn btn btn-primary">Proceed</button>
            </form>
        </x-block>
    </x-container>
    @if (count($zirlais) > 0)
        <x-container>
            <x-block>
                <x-slot name="heading">
                    The following MZU IDs/ Roll nos. are found. Click the matching data to proceed
                </x-slot>
                <div>
                    <table class="table">
                        <tr>
                            <th>MZU ID</th>
                            <th>rollno</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Select</th>
                        </tr>
                        @foreach ($zirlais as $zl)
                            <tr>
                                <td>{{ $zl->mzuid }}</td>
                                <td>{{ $zl->rollno }}</td>
                                <td>{{ $zl->name }}</td>
                                <td>{{ $zl->course->name }}</td>
                                <td>
                                    <a class="btn btn-primary"
                                        href="/diktei/option?zirlai_id={{ $zl->id }}&mzuid={{ $zl->mzuid }}">Select</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </x-block>
        </x-container>
    @elseif($mzuid != '')
        <x-container>
            <x-block>
                <span class="text-danger">MZU ID/ Roll number is not found</span>
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
</x-diktei>
