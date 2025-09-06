<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications:
                <p>
                    <a href="/application/list" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications arranged in dept-wise, and then percentage, excluding AMC
            </x-slot>
            <p>
                Select the Department:
                <select name="department" id="department">
                    <option value="0">All</option>
                    @foreach (App\Models\Department::all() as $dept)
                        <option value="{{ $dept->id }}" {{ $dept->id == $department_id ? 'selected' : '' }}>
                            {{ $dept->name }}</option>
                    @endforeach
                </select>
            </p>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Course</th>
                            <th>Address</th>
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
                                <td>
                                    <a
                                        href="/application/{{ $application->id }}?mzuid={{ $application->mzuid }}">{{ $application->name }}</a>
                                    @if (count($application->duplicates()) > 0)
                                        <br><button type="button" class="btn badge bg-warning btn-duplicate"
                                            value="{{ $application->id }}">Possible duplicate</button>
                                    @endif

                                </td>
                                <td>{{ $application->gender }}</td>
                                <td>{{ $application->course }}</td>
                                <td>{{ $application->address }}</td>
                                @if ($application->hostel)
                                    <td>{{ $application->hostel->name }}</td>
                                @else
                                    <td>{{ $application->status }}</td>
                                @endif

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
                        <form name="frm-delete" method="post">
                            @csrf
                            @method('delete')
                        </form>
                    </tbody>
                </table>
                @if (!$department)
                    <div class="d-flex justify-content-center">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </x-block>
    </x-container>
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
                        $("form[name='frm-delete']").attr('action', '/application/' + $(this).val());
                        $("form[name='frm-delete']").submit();
                    }
                });
                $("select[name='department']").change(function() {
                    if ($(this).val() == '0') {
                        location.replace('/application/priority-list');
                        exit();
                    } else {
                        location.replace('/application/priority-list?department_id=' + $(this).val());
                        exit();
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
        </script>
    </x-layout>
