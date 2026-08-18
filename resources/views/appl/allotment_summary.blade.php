<x-appl-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Allotment summary
                <p>
                    <a class="btn btn-primary btn-sm" href='/appl/'>Back</a>
            </x-slot>
                <div style="width=100%; overflow-x: auto">
                    <table class="table">
                        <tr>
                            <th>Department</th>
                            <th>Male</th>
                            <th>Female</th>
                        </tr>
                        @foreach($departments as $dept)
                            <tr>
                                <td>{{ $dept->department }}</td>
                                <td>{{ $dept->male }}</td>
                                <td>{{ $dept->female }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>



                <div style="width=100%; overflow-x: auto">
                    <table class="table">
                        <tr>
                            <th>Hostel</th>
                            <th>Room type</th>
                            <th>Count</th>
                        </tr>
                        @foreach($hostels as $hostel)
                            <tr>
                                <td>{{ $hostel->hostel }}</td>
                                <td>{{ App\Models\Room::room_type($hostel->type) }}</td>
                                <td>{{ $hostel->cnt }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan=2>No hostel assigned</th>
                        </tr>
                        <tr>
                            <td><a href="/appl/allotted?gender=Male">Male</a></td><td>{{ $no_hostel->male }}</td>
                            <td><a href="/appl/allotted?gender=Female">Female</a></td><td>{{ $no_hostel->female }}</td>
                        </tr>
                    </table>
                </div>

        </x-block>
        <x-block>
            <x-slot name="heading">
                Vacancy
            </x-slot>
            <div style="width:100%; overflow-x: auto">
                <table class="table">
                    <tr>
                        <th>Hostel</th>
                        <th>Room type</th>
                        <th>Total</th>
                        <th>Occupied</th>
                        <th>Vacant</th>
                    </tr>
                    @foreach($vacancies as $vacancy)
                        <tr>
                            <td>{{ $vacancy->Hostel }}</td>
                            <td>{{ $vacancy->Type }}</td>
                            <td>{{ $vacancy->Total }}</td>
                            <td>{{ $vacancy->Occupied }}</td>
                            <td>{{ $vacancy->Vacant }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan=2></th>
                    </tr>
                </table>
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
</x-appl-layout>
