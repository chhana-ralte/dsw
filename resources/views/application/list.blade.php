<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications:
                <div class="btn-group">
                    <a href="/application/list" class="btn btn-primary">
                        Applied
                        <span class="badge bg-secondary">{{ App\Models\Application::applied()->count() }}</span>
                    </a>
                    <a href="/application/list?status=Declined" class="btn btn-danger">
                        Declined
                        <span class="badge bg-secondary">{{ App\Models\Application::declined()->count() }}</span>
                    </a>
                    <a href="/application/list?status=Pending" class="btn btn-warning">
                        Pending
                        <span class="badge bg-secondary">{{ App\Models\Application::pending()->count() }}</span>
                    </a>
                    <a href="/application/list?status=Approved" class="btn btn-success">
                        Approved
                        <span class="badge bg-secondary">{{ App\Models\Application::approved()->count() }}</span>
                    </a>
                </div>
                <p>
                    <a href="/application/" class="btn btn-secondary btn-sm">Back</a>
                </p>

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
                            @can('manages', App\Models\Application::class)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td><a href="/application/{{ $application->id }}?mzuid={{ $application->mzuid }}">{{ $application->name }}</a>
                                </td>

                                <td>{{ $application->course }}</td>
                                <td>{{ $application->department }}</td>
                                <td>{{ $application->mzuid }}</td>

                                <td>{{ $application->status }}</td>
                                @can('manage', $application)
                                    <td>
                                        <div class="btn-group">
                                            <a href="/application/{{ $application->id }}/edit?mzuid={{ $application->mzuid }}" class="btn btn-primary btn-sm">Edit</a>
                                            <button value="{{ $application->id }}" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                        </div>
                                    </td>
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
            $("button.btn-delete").click(function() {
                if (confirm("Are you sure you want to delete this application?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).attr("value") + "/delete",
                        success: function(data, status) {
                            if (data == "Success") {
                                alert("Application deleted successfully");
                                location.replace("/application/list");
                            }
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }
            });
        });
    </script>
</x-layout>
