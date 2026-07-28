<x-layout>
    {{-- @foreach([$males,$females] as $gender) --}}
        <x-container>
            <x-block>
                <x-slot name="heading">
                    Applicants from {{ $department->name }}
                    <p>
                        <a class="btn btn-primary btn-sm" href="/appl">Back</a>
                    </p>
                </x-slot>

                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th>Application ID</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>MZU ID</th>
                                <th>AMC?</th>
                                <th>PWD?</th>
                                <th>BPL/AAY?</th>
                                <th>Status</th>
                                <th>Score</th>
                                @can('manages', App\Models\Application::class)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)

                                <tr>

                                @if($application->gender == 'Male')
                                    <td style="background-color: blue">{{ $application->id }}</td>
                                @else
                                    <td style="background-color: pink">{{ $application->id }}</td>
                                @endif
                                    <td>
                                        <a
                                            href="/appl/{{ $application->id }}?">{{ $application->name }}</a>
                                        

                                    </td>

                                    <td>{{ $application->course }}</td>
                                    {{-- <td>{{ $application->department }}</td> --}}
                                    <td>{{ $application->mzuid }}</td>
                                    <td>{{ $application->AMC ? 'Yes' : 'No' }}</td>
                                    <td>{{ $application->PWD ? 'Yes' : 'No' }}</td>
                                    <td>{{ $application->BPL }}</td>
                                    @if ($application->hostel)
                                        <td>{{ $application->hostel->name }}({{ $application->roomtype }})</td>
                                    @else
                                        <td>{{ $application->status }}</td>
                                    @endif
                                    <th>{{ $application->total_score }}</th>

                                    @can('manage', $application)
                                        <td>
                                            <div class="btn-group">
                                                <a href="/application/{{ $application->id }}/edit?mzuid={{ $application->mzuid }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <button value="{{ $application->id }}"
                                                    class="btn btn-danger btn-sm btn-delete">Delete</button>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </x-block>
        </x-container>
    {{-- @endforeach --}}
        {{-- Modal for duplicate requirement --}}

        <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="duplicateModalLabel">Possible duplicates</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="duplicate" class="col-form-label">Duplicates from existing allotment</label>
                                <div class="col-md-12" style="width : 100%; overflow-x : auto" id="app">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Alltmt. ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>MZU ID</th>
                                            <th>Course - Department</th>
                                        </tr>
                                        <tbody id="app-body">
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <textarea class="form-control" id="duplicate" name="duplicate"></textarea> --}}
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal for duplicate requirement --}}

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
                        type: "delete",
                        url: "/ajax/appl/" + $(this).val() + "/delete",
                        success: function(data, status) {
                            alert("Application deleted successfully.");
                            {{-- alert(data.id) --}}
                            location.replace("/appl/department/" + data.department_id);
                            {{-- location.reload(); --}}
                        },
                        error: function(xhr, status, error) {
                            alert("Error deleting application: " + xhr.responseText);
                        }
                    });

                        
                    }
                });
            });

            $("button.btn-duplicate").click(function() {
                $.ajax({
                    type: "get",
                    url: "/application/" + $(this).val() + "/duplicate",
                    success: function(data, status) {
                        $("#app-body").empty();
                        for (var i = 0; i < data.length; i++) {
                            $("#app-body").append("<tr><td>" + data[i].id + "</td><td>" + data[i].name +
                                "</td><td>" + data[i].mobile + "</td><td>" + data[i].mzuid +
                                "</td><td>" + data[i].course + " - " + data[i].department + "</td></tr>"
                            );
                        }

                    },
                    error: function(xhr, status, error) {
                        alert("Error getting duplicate: " + xhr.responseText);
                    }
                })
                $("textarea#duplicate").val($(this).val());
                $("#duplicateModal").modal('show');
            });

            $("select#hostel").change(function() {
                window.location.href = "/application/list?status=Approved&hostel=" + $(this).val();
            });
        </script>
    </x-layout>
