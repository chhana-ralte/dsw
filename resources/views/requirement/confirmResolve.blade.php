<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Click 'confirm' to resolve the selected students.

                <span class="text-danger">Students can not be resolved if their email and mobile number are not
                    updated.</span>

                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ url()->previous() }}">
                        Back
                    </a>
                </p>

            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form name="frm-submit" method="post" action="/requirement/list">
                    @csrf
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="action">
                    <input type="hidden" name="hostel_id" value="{{ $hostel ? $hostel->id : 0 }}">
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="all"></th>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Student info</th>
                                <th>Requirement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            @foreach ($requirements as $req)
                                <tr>

                                    <td>
                                        @if ($req->person->mobile != '' && $req->person->email != '' && $req->allotment->valid == 1)
                                            <input type="checkbox" name="requirement_id[]" value="{{ $req->id }}"
                                                checked>
                                        @else
                                            <input type="checkbox" disabled>
                                        @endif
                                    </td>
                                    <td>{{ $sl++ }}</td>
                                    <td>

                                        {{ $req->person->name }}
                                        @if ($req->person->mobile == '' || $req->person->email == '')
                                            <br><span class="badge bg-danger">No mobile or email</span>
                                        @endif

                                        @if ($req->allotment->valid == 0)
                                            <br><span class="badge bg-danger">Possible invalid allotment</span>
                                        @endif

                                    </td>

                                    <td>
                                        @if ($req->person->student())
                                            ({{ $req->person->student()->department }}:
                                            {{ $req->person->student()->course }})
                                        @elseif($req->person && $req->person->other())
                                            Not a student ({{ $req->person->other()->remark }})
                                        @else
                                            ( No Info about the person )
                                        @endif
                                    </td>

                                    <td>
                                        <input type="hidden" name="new_hostel_id[{{ $req->id }}]"
                                            value="{{ $new[$req->id]['hostel_id'] }}">
                                        <input type="hidden" name="new_roomcapacity[{{ $req->id }}]"
                                            value="{{ $new[$req->id]['room_capacity'] }}">
                                        Hostel: {{ $new[$req->id]['hostel_name'] }}<br>
                                        Type: {{ $new[$req->id]['room_type'] }}<br>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <footer>
                            <tr>
                                <td colspan="6">
                                    @if (auth()->user()->can('resolves', App\Models\Requirement::class) ||
                                            auth()->user()->isWardenOf($hostel ? $hostel->id : 0))
                                        <button class="btn btn-primary btn-action" type="button"
                                            value="resolve">Confirm</button>
                                    @endif

                                </td>
                            </tr>
                        </footer>
                    </table>
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
                            <label for="duplicate" class="col-form-label">Duplicates from new application</label>
                            <div class="col-md-12" style="width:100%;overfloy-x:auto" id="app">
                                <table class="table table-bordered table-striped">
                                    <tr>
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.table tr').click(function(event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });

            $("button.btn-action").click(function() {
                var nos = 0;
                $("input[name='requirement_id[]']").each(function() {
                    if ($(this).prop('checked')) {
                        nos++;
                    }
                });

                if (nos == 0) {
                    alert("Please select the students.");
                    return false;
                } else {
                    $("input[name='action']").val($(this).val());
                    $("form[name='frm-submit']").submit();
                }
            });

            $("input#all").click(function() {

                $("input[name='requirement_id[]']").each(function() {
                    $(this).prop('checked', $("input#all").prop("checked"));
                });
            });




        });
    </script>
</x-layout>
