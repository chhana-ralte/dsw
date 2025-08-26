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
                    <a href="/application/list?status=Approved&hostel=0" class="btn btn-success">
                        Approved (No hostel)
                        <span class="badge bg-secondary">{{ App\Models\Application::approved()->count() }}</span>
                    </a>
                    <a href="/application/approved" class="btn btn-success">
                        Approved
                        <span class="badge bg-secondary">{{ App\Models\Application::approved_hostel()->count() }}</span>
                    </a>
                    <a href="/application/notified" class="btn btn-success">
                        Notified
                        <span class="badge bg-secondary">{{ App\Models\Application::notified()->count() }}</span>
                    </a>
                </div>

                <p>
                    <a href="/application/" class="btn btn-secondary btn-sm">Back</a>
                    <a href="/application/search" class="btn btn-primary btn-sm">Search</a>
                </p>

            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Applications
            </x-slot>
            @if ($status == 'Approved' && $hostel_id != 0)
                <p>
                    Select the hostel:
                    <select name="hostel" id="hostel">
                        <option value="0">No Hostel</option>
                        @foreach (App\Models\Hostel::orderBy('gender')->orderBy('name')->get() as $ht)
                            <option value="{{ $ht->id }}">{{ $ht->name }}</option>
                        @endforeach
                    </select>
                </p>
            @endif
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <thead>

                        <tr>
                            <th>Application ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            <th>AMC?</th>
                            <th>Status</th>
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
                                            href="/application/{{ $application->id }}?mzuid={{ $application->mzuid }}">{{ $application->name }}</a>
                                        @if (count($application->duplicates()) > 0)
                                            <br><button type="button" class="btn badge bg-warning btn-duplicate"
                                                value="{{ $application->id }}">Possible duplicate</button>
                                        @endif

                                    </td>

                                    <td>{{ $application->course }}</td>
                                    <td>{{ $application->department }}</td>
                                    <td>{{ $application->mzuid }}</td>
                                    <td>{{ $application->AMC ? 'Yes' : 'No' }}</td>
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
                    <div class="d-flex justify-content-center">
                        {{ $applications->links() }}
                    </div>
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
