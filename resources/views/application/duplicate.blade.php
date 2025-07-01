<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Duplicate applications/allotment
            </x-slot>
            <div style="width : 100%; overflow-x: auto;">
                <table class="table">
                    <tr>
                    <th>Application name</th>
                    <th>Allotment name</th>
                    <th>MZU ID</th>
                    <th>Course</th>
                    <th>Department</th>
                    </tr>
                    @foreach($duplicates as $duplicate)
                    <tr>
                        <td><a href="/application/{{ $duplicate->application_id }}?mzuid={{ $duplicate->mzuid }}">{{ $duplicate->application_name }}</a></td>
                        <td><a href="/allotment/{{ $duplicate->allotment_id }}">{{ $duplicate->allotment_name }}</a></td>
                        <td>{{ $duplicate->mzuid }}</td>
                        <td>{{ $duplicate->course }}</td>
                        <td>{{ $duplicate->department }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
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
