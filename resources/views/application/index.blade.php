<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            <th>Status</th>
                            @if (auth()->user()->max_role_level() >= 3)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td>{{ $application->person->name }}</td>
                                @if ($application->person->student())
                                    <td>{{ $application->person->student()->course }}</td>
                                    <td>{{ $application->person->student()->department }}</td>
                                    <td>{{ $application->person->student()->mzuid }}</td>
                                @endif
                                <td>{{ $application->status }}</td>
                                @if (auth()->user()->max_role_level() >= 3)
                                    <td><a href="/application/{{ $application->id }}/edit"
                                            class="btn btn-primary btn-sm">Edit</a></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
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
