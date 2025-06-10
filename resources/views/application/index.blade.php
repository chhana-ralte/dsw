<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications:
                <div class="btn-group">
                    <a href="/application/" class="btn btn-primary">Applied</a>
                    <a href="/application?status=Declined" class="btn btn-danger">Declined</a>
                    <a href="/application?status=Pending" class="btn btn-warning">Pending</a>
                    <a href="/application?status=Approved" class="btn btn-success">Approved</a>
            </x-slot>
        </x-block>
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
                            @if (auth()->user() && auth()->user()->max_role_level() >= 3)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td><a href="/application/{{ $application->id }}">{{ $application->person->name }}</a>
                                </td>
                                @if ($application->person->student())
                                    <td>{{ $application->person->student()->course }}</td>
                                    <td>{{ $application->person->student()->department }}</td>
                                    <td>{{ $application->person->student()->mzuid }}</td>
                                @endif
                                <td>{{ $application->status }}</td>
                                @can('manage', $application)
                                    <td><a href="/application/{{ $application->id }}/edit"
                                            class="btn btn-primary btn-sm">Edit</a></td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $applications->links() }}
                </div>
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
