<x-layout>
    {{-- @foreach([$males,$females] as $gender) --}}
        <x-container>
            <x-block>
                <x-slot name="heading">
                    @if($hostel)
                    Allotted to {{ $hostel->name }}
                    @else
                    No hostel allotted
                    @endif
                    <p>
                        @if(isset($back_link))
                        <a class="btn btn-primary btn-sm" href="{{ $back_link }}">Back</a>
                        @else
                        <a class="btn btn-primary btn-sm" href="/appl">Back</a>
                        @endif
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
                            @foreach ($allotted as $application)

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
                                    @if ($application->hostel_id)
                                        <td><button class="btn-allot" value="{{ $application->id }}">{{ $application->hostel->name }}({{ $application->roomtype }})</button></td>
                                    @else
                                        <td><button class="btn-allot" value="{{ $application->id }}">{{ $application->status }}</button></td>
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

            {{-- Modal for hostel allotment --}}
    <div class="modal fade" id="hostelModal" tabindex="-1" aria-labelledby="hostelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hostelModalLabel">Assign Hostel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="application_id">
                        <div class="mb-3">
                            <label for="hostel" class="col-form-label">Hostel</label>
                            <select id="hostel" name="hostel" class="form-control">
                                <option value="" disabled selected>Select hostel</option>

                                @foreach ($hostels as $h)
                                    @if (auth()->user() && auth()->user()->isWardenOf($h->id))
                                        <option value="{{ $h->id }}" selected>{{ $h->name }}</option>
                                    @else
                                        <option value="{{ $h->id }}">{{ $h->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="col-form-label">Room type:</label>
                            <select id="type" name="type" class="form-control">
                                <option value="1">Single</option>
                                <option value="2" selected>Double</option>
                                <option value="3">Triple</option>
                                <option value="4">Dorm</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-status" value="approve">Just approve</button>
                    <button type="button" class="btn btn-primary btn-status" value="approve-hostel">Approve hostel</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for hostel allotment --}}


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

            $("button.btn-allot").click(function() {
                // alert($(this).val());
                $("input[name='application_id']").val($(this).val());
                $("#hostelModal").modal("show");
            });


            $("button.btn-status").click(function() {
                //alert("asdsadsad");
                if ($(this).val() == 'approve-hostel'){
                    if(!$("select#hostel").val()){
                        alert("Select the hostel where student is to be allotted. Or click 'Just Approve' without hostel");
                    }
                    else{
                        $.ajax({
                            url : '/appl/' + $("input[name='application_id']").val() + '/statusUpdate?ajax=1',
                            type : 'put',
                            data: {
                                'ajax' : 1,
                                'status' : 'approve',
                                'hostel_id' : $("select#hostel").val(),
                                'roomtype' : $("select#type").val(),
                            },
                            success : function(data, status){
                                alert(data);
                                location.reload();
                            },
                            error : function(){
                                alert("Error");
                            }
                        });
                    }
                }
                else {
                    $.ajax({
                        url : '/appl/' + $("input[name='application_id']").val() + '/statusUpdate?ajax=1',
                        type : 'put',
                        data: {
                            'ajax' : 1,
                            'status' : 'approve',
                            'hostel_id' : 0,
                            'roomtype' : 0,
                        },
                        success : function(data, status){
                            alert(data);
                            location.reload();
                        },
                        error : function(){
                            alert("Error");
                        }
                    });
                }
            });
        </script>
    </x-layout>
