<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Approved applications for {{ $hostel_id == 0 ? 'All hostels' : $hostel->name }}
                <p>
                    <a href="/application/list" class="btn btn-secondary btn-sm">Back</a>

                </p>

            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications
            </x-slot>

            <p>
                Select the hostel:
                <select name="hostel" id="hostel">
                    <option value="0" selected disabled>Select Hostel</option>
                    @foreach (App\Models\Hostel::orderBy('gender')->orderBy('name')->get() as $ht)
                        <option value="{{ $ht->id }}" {{ $ht->id == $hostel_id ? 'selected' : '' }}>
                            {{ $ht->name }}</option>
                    @endforeach
                </select>
            </p>

            <div style="width: 100%; overflow-x:auto">
                <form name="frm-notify" method="post" action="">
                    @csrf
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="hostel_id" value="{{ $hostel?$hostel->id:0 }}">
                    <table class="table table-auto table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="all"></th>
                                <th>Sl.</th>
                                <th>Application ID</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>MZU ID</th>
                                <th>Hostel</th>
                                <th>Type</th>
                                @can('manages', App\Models\Application::class)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($hostel_id != 0) {
                                $sl = 1;
                            } else {
                                $sl = ($applications->currentPage() - 1) * $applications->perPage() + 1;
                            }
                            ?>
                            @foreach ($applications as $application)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="application_id[]" value="{{ $application->id }}">
                                    </td>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $application->id }}</td>
                                    <td>
                                        <a
                                            href="/application/{{ $application->id }}?mzuid={{ $application->mzuid }}">{{ $application->name }}</a>
                                    </td>

                                    <td>{{ $application->course }}</td>
                                    <td>{{ $application->mzuid }}</td>
                                    <td>{{ $application->hostel->name }}</td>

                                    <td>{{ App\Models\Room::room_type($application->roomtype) }}</td>


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
                            @if($hostel_id != 0 && auth()->user()->can('notifies', App\Models\Application::class))
                                <footer>

                                    <tr>
                                        <td colspan="6">

                                                <button id="notify" class="btn btn-primary btn-action" type="button" value="notify">Notify selected students</button>

                                        </td>
                                    </tr>
                                </footer>
                                @endif

                        </tbody>
                    </table>
                    @if ($hostel_id == 0)
                        <div class="d-flex justify-content-center">
                            {{ $applications->links() }}
                        </div>
                    @endif
                </form>
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

                $("select#hostel").change(function() {

                    window.location.href = "/application/approved?hostel=" + $(this).val();
                });

                $('.table tr').click(function(event) {
                    if (event.target.type !== 'checkbox') {
                        $(':checkbox', this).trigger('click');
                    }
                });

                $("input#all").click(function(){
                    $("input[name='application_id[]']").each(function(){
                        $(this).prop('checked',$("input#all").prop("checked"));
                    });
                });
                $("button#notify").click(function(){
                    var nos=0;
                    $("input[name='application_id[]']").each(function(){
                        if($(this).prop('checked')){
                            nos++;
                        }
                    });

                    if(nos == 0){
                        alert("Please select the students.");
                        exit();
                    }
                    $("form[name='frm-notify']").submit();
                });

            });

        </script>
    </x-layout>
