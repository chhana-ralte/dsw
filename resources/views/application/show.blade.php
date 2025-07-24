<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications details
                <p>
                    @can('manage', $application)
                        <a href="/application/list" class="btn btn-secondary btn-sm">Back</a>
                    @endcan
                    <a href="/application/{{ $application->id }}/edit?mzuid={{ $application->mzuid }}" class="btn btn-secondary btn-sm">Edit</a>
                    @if(auth()->user() && (auth()->user()->isDsw() || auth()->user()->isAdmin()))
                        <button class="btn btn-danger btn-delete btn-sm" value="{{ $application->id }}">Delete</button>
                    @endif
                </p>
                <form name="frm-navigate" method="post" action="/application/navigate">
                    @csrf
                    <input type="hidden" name="navigation" value="">
                    @can('manages',App\Models\Application::class)
                        <div class="btn-group">

                            <?php
                                if($prev){
                                    $str_prev = "href=/application/" . $prev->id . "?mzuid=" . $prev->mzuid;
                                }
                                if($next){
                                    $str_next = "href=/application/" . $next->id . "?mzuid=" . $next->mzuid;
                                }
                            ?>
                            @if($prev)
                                <a class="btn btn-primary btn-navigate" href="/application/{{ $prev->id }}?mzuid={{ $prev->mzuid }}">&lt;&lt;Prev</a>
                            @else
                                <button class="btn btn-primary btn-navigate" disabled>&lt;&lt;Prev</button>
                            @endif

                            <input type=text style="text-align: center" size="3" name="application_id" value="{{ $application->id }}">

                            @if($next)
                                <a class="btn btn-primary btn-navigate" href="/application/{{ $next->id }}?mzuid={{ $next->mzuid }}">Next&gt;&gt;</a>
                            @else
                                <button class="btn btn-primary btn-navigate" disabled>Next&gt;&gt;</button>
                            @endif
                        </div>
                    @endcan
                </form>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Personal information
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <tr>
                        <th>Name</th>
                        <td>{{ $application->name }}</td>
                        <td rowspan=7><img width="200px" src="{{ $application->photo }}" alt=""
                                srcset=""></td>
                    </tr>
                    <tr>
                        <th>Father/Guardian's name</th>
                        <td>{{ $application->father }}</td>
                    </tr>

                    <tr>
                        <th>Date of birth</th>
                        <td>{{ date_format(date_create($application->dob),'d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Marital status</th>
                        <td>{{ $application->married?'Married':'Single/Divorced' }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ $application->gender }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $application->mobile }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $application->email }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $application->category }}</td>
                    </tr>
                    <tr>
                        <th>Person with disability?</th>
                        <td>{{ $application->PWD?'Yes':'No' }}</td>
                    </tr>
                    <tr>
                        <th>State/UT</th>
                        <td>{{ $application->state }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{!! nl2br($application->address) !!}</td>
                    </tr>
                    <tr>
                        <th>Whether in Aizawl Municipality Area?</th>
                        <td>{{ $application->AMC?'Yes':'No' }}</td>
                    </tr>
                </table>
            </div>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Students' information
            </x-slot>
            <table class="table table-auto">
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Rollno</td>
                    <td>{{ $application->rollno==''?'Not set':$application->rollno }}</td>
                </tr>
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Course name</td>
                    <td>{{ $application->course }}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>{{ $application->department }}</td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td>{{ $application->semester }}</td>
                </tr>
                </tr>
                    <td>MZU ID</td>
                    <td>{{ $application->mzuid }}</td>
                </tr>
                <tr>
                    <td>Last percentage</td>
                    <td>{{ $application->percent }}</td>
                </tr>
            </table>
        </x-block>

        <x-block>
            <x-slot name="heading">
                Application information
            </x-slot>
            <table class="table table-auto">
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Application ID</td>
                    <td>{{ $application->id }}</td>
                </tr>
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Submission date</td>
                    <td>{{ $application->dt }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $application->status }}</td>
                </tr>
                @if($application->hostel)
                    <tr>
                        <td>Hostel allotted</td>
                        <td>{{ $application->hostel->name }}</td>
                    </tr>
                    <tr>
                        <td>Room type</td>
                        <td>{{ App\Models\Room::room_type($application->roomtype) }}</td>
                    </tr>
                    @if($application->valid_allotment())
                        <tr>
                            <td>Allotment reference</td>
                            <td>{{ $application->valid_allotment()->notification->id }}/{{ $application->valid_allotment()->rand }}/{{ $application->valid_allotment()->sl }}</td>
                        </tr>
                    @endif
                @endif
                </tr>
                    <td>Whether valid?</td>
                    <td>{{ $application->valid ? 'Yes' : 'No' }}</td>
                </tr>
                </tr>
                    <td>Reason for hostel requirement</td>
                    <td>{!! nl2br($application->reason) !!}</td>
                </tr>
                @if($application->remark)
                    </tr>
                        <td>Remark</td>
                        <td>{!! nl2br($application->remark) !!}</td>
                    </tr>
                @endif
                @can('manage', $application)
                    </tr>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#remarkModal" data-bs-whatever="Remark">Add/Edit remark</button>
                        </td>
                    </tr>
                @endcan


            </table>
        </x-block>
        @if(count($application->existing_allotments()) > 0)
            <x-block>
                <x-slot name="heading">
                    <span class="text-danger">The following existing allotment(s) are found</span>
                </x-slot>
                <div style="width:100%; overflow-x:auto">
                    <table class="table">
                        <tr>
                            <th>Alltment ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>Current hostel</th>
                        </tr>
                        @foreach($application->existing_allotments() as $allotment)
                            <tr>
                                <td>
                                    <a href="/allotment/{{ $allotment->id }}">{{ $allotment->id }}</a>
                                </td>
                                <td>
                                    {{ $allotment->person->name }}
                                </td>
                                @if($allotment->person->student())
                                    <td>
                                        {{ $allotment->person->student()->course }}
                                    </td>
                                    <td>
                                        {{ $allotment->person->student()->department }}
                                    </td>
                                @else
                                    <td colspan=2>
                                        Not a student
                                    </td>
                                @endif
                                @if($allotment->valid_allot_hostel())
                                    <td>
                                        {{ $allotment->valid_allot_hostel()->hostel->name }}
                                    </td>
                                @else
                                    <td colspan=2>
                                        No valid hostel
                                    </td>
                                @endif

                            </tr>

                        @endforeach
                    </table>
                </div>
            </x-block>
        @endif

        @can('manage',$application)
            <x-block>
                <x-slot name="heading">
                    Decision:
                </x-slot>
                <div>
                    <button class="btn btn-danger btn-status" value="decline">Decline</button>
                    <button class="btn btn-warning btn-status" value="pending">Pending</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hostelModal" data-bs-whatever="Remark">Approve</button>
                    @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isDsw()))
                        <a class="btn btn-warning btn-existing" href="/application/{{ $application->id }}/existing">Add as existing</a>
                    @endif
                </div>
                <form type="hidden" action="/application/{{ $application->id }}/statusUpdate" method="post" name="frm_submit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    <input type="hidden" name="status" value="">
                    <input type="hidden" name="hostel_id">
                    <input type="hidden" name="roomtype">
                </form>
            </x-block>
        @endcan
    </x-container>

{{-- Modal for remarks --}}
<div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="remarkModalLabel">Add/ Edit remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="remark" class="col-form-label">Remark:</label>
                        <textarea class="form-control" id="remark" name="remark">{{ old('remark',$application->remark) }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save">Save</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal for remarks --}}

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
                    <div class="mb-3">
                        <label for="hostel" class="col-form-label">Hostel</label>
                        <select id="hostel" name="hostel" class="form-control">
                            <option value="" disabled selected>Select hostel</option>

                            @foreach($hostels as $h)
                                @if(auth()->user() && auth()->user()->isWardenOf($h->id))
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

            $("button.btn-status").click(function() {
                if($(this).val() == 'approve-hostel'){
                    $("input[name='status']").val($(this).val());
                    $("input[name='hostel_id']").val($("select#hostel").val());
                    $("input[name='roomtype']").val($("select#type").val());
                    $("form[name='frm_submit']").submit();
                }
                else {
                    $("input[name='status']").val($(this).val());
                    $("form[name='frm_submit']").submit();
                }
            });

            $("button.btn-approve").click(function() {
                alert($(this).val());
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).val() + "/accept",
                        success: function(data, status) {
                            alert("Application accepted successfully.");
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Error accepting application: " + xhr.responseText);
                        }
                    });

            });

            $("button.btn-delete").click(function(){
                if(confirm("Are you sure you want to delete this application?")){
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).val() + "/delete",
                        success: function(data, status) {
                            alert("Application deleted successfully.");
                            {{-- alert(data.id) --}}
                            location.replace("/application/" + data.id);
                            {{-- location.reload(); --}}
                        },
                        error: function(xhr, status, error) {
                            alert("Error deleting application: " + xhr.responseText);
                        }
                    });
                }
            });

            {{-- $("button.btn-approve").click(function() {
                if (confirm("Are you sure you want to approve this application?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).val() + "/accept",
                        success: function(data, status) {
                            alert("Application accepted successfully.");
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Error accepting application: " + xhr.responseText);
                        }
                    });
                }
            }); --}}
            $("button.btn-save").click(function() {

                $.ajax({
                    type: "post",
                    url: "/ajax/application/" + $("input[name='application_id']").val() + "/remark",
                    data: {
                        remark: $("#remark").val()
                    },
                    success: function(data, status) {
                        {{-- alert("Remark saved successfully."); --}}
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Error saving remark: " + xhr.responseText);
                    }
                });

            });

            $("button.btn-navigate").click(function(){
                $("input[name='navigation']").val($(this).val());
                $("form[name='frm-navigate']").submit();
            });

        });
    </script>
</x-layout>
