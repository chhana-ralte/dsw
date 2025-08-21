<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Newly allotted inmates of {{ $hostel->name }} Hall of Residence for the {{ $sessn->name() }} session.
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    @if ($adm_type == 'old')
                        <a class="btn btn-secondary btn-sm"
                            href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}&adm_type=new">New
                            admissions</a>
                    @else
                        <a class="btn btn-secondary btn-sm"
                            href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}">Existing
                            admissions</a>
                    @endif
                    <input style="font-size:15px" type="text" name="find" />
                </p>
            </x-slot>
            <form>
                <input type="hidden" id="allotment_id">
            </form>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Room type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>
                        @foreach ($new_allotments as $allotment)
                            <tr class="table-white row_{{ $allotment->id }}">
                                <td>{{ $sl++ }}</td>
                                <td class="name">

                                    <a
                                        href="/allotment/{{ $allotment->id }}?back_link=/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}&adm_type=new">{{ $allotment->person->name }}</a>


                                    @if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->hostel->id != $allotment->hostel->id)
                                        <br><span class="badge bg-warning">Now in
                                            {{ $allotment->valid_allot_hostel()->hostel->name }}</span>
                                    @endif
                                </td>
                                @if ($allotment->person->student())
                                    <td>{{ $allotment->person->student()->course }}</td>
                                @elseif($allotment->person->other())
                                    <td colspan="2"><b>Not a student ({{ $allotment->person->other()->remark }})</b>
                                    </td>
                                @else
                                    <td colspan="2"><b>No info</b></td>
                                @endif
                                <td>

                                    @if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat())
                                        <span class="text-success">
                                            Seat:
                                            {{ $allotment->valid_allot_hostel()->valid_allot_seat()->seat->room->roomno }}
                                        </span>
                                    @else
                                        <span class="text-warning">
                                            Seat: Not assigned
                                        </span>
                                    @endif
                                    <br>
                                    @if ($allotment->confirmed)
                                        <span class="text-success">
                                            Admission : Confirmed
                                        </span>
                                    @elseif($allotment->valid)
                                        <span class="text-warning">
                                            Admission : Pending
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            Admission : Declined
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($allotment->application)
                                        {{ App\Models\Room::room_type($allotment->application->roomtype) }}
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                {{-- <td>

                                    <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/admission/create?sessn_id={{ $sessn->id }}">Options</a>
                                </td> --}}
                                <td>
                                    <div class="btn-group">
                                        @if ($allotment->valid)
                                            @if (
                                                $allotment->valid_allot_hostel() &&
                                                    ($allotment->valid_allot_hostel()->valid_allot_seat() ||
                                                        $allotment->valid_allot_hostel()->hostel->id != $allotment->hostel->id))
                                                <button class="btn btn-primary btn-sm btn-allot-seat"
                                                    value="{{ $allotment->id }}" disabled>Allot seat</button>
                                            @else
                                                <button class="btn btn-primary btn-sm btn-allot-seat"
                                                    value="{{ $allotment->id }}">Allot seat</button>
                                            @endif
                                            @if ($allotment->valid_allot_hostel() && $allotment->confirmed == 0)
                                                <button class="btn btn-secondary btn-sm btn-admission"
                                                    value="{{ $allotment->id }}">Admit</button>
                                            @else
                                                <button class="btn btn-secondary btn-sm btn-admission"
                                                    value="{{ $allotment->id }}" disabled>Admit</button>
                                            @endif

                                            @if ($allotment->confirmed == 0)
                                                <button class="btn btn-danger btn-sm btn-decline"
                                                    value="{{ $allotment->id }}">Decline</button>
                                            @else
                                                <button class="btn btn-danger btn-sm btn-decline"
                                                    value="0">Decline</button>
                                            @endif
                                        @else
                                            Invalid
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($old_allotments) > 0)
                            <tr>
                                <td colspan="6">
                                    Admissions from previous sessions (Who are not yet approved).
                                </td>
                            </tr>
                            <tr>
                                <th>Sl.</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Room type</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($old_allotments as $allotment)
                                <tr class="table-white row_{{ $allotment->id }}">
                                    <td>{{ $sl++ }}</td>
                                    <td class="name">
                                        @if (auth()->user() && (auth()->user()->isDsw() || auth()->user()->isAdmin()))
                                            <a
                                                href="/allotment/{{ $allotment->id }}">{{ $allotment->person->name }}</a>
                                        @else
                                            {{ $allotment->person->name }}
                                        @endif
                                        @if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->hostel->id != $allotment->hostel->id)
                                            <br><span class="badge bg-warning">Now in
                                                {{ $allotment->valid_allot_hostel()->hostel->name }}</span>
                                        @endif
                                    </td>
                                    @if ($allotment->person->student())
                                        <td>{{ $allotment->person->student()->course }}</td>
                                    @elseif($allotment->person->other())
                                        <td colspan="2"><b>Not a student
                                                ({{ $allotment->person->other()->remark }})
                                            </b>
                                        </td>
                                    @else
                                        <td colspan="2"><b>No info</b></td>
                                    @endif
                                    <td>

                                        @if ($allotment->valid_allot_hostel() && $allotment->valid_allot_hostel()->valid_allot_seat())
                                            <span class="text-success">
                                                Seat:
                                                {{ $allotment->valid_allot_hostel()->valid_allot_seat()->seat->room->roomno }}
                                            </span>
                                        @else
                                            <span class="text-warning">
                                                Seat: Not assigned
                                            </span>
                                        @endif
                                        <br>
                                        @if ($allotment->confirmed)
                                            <span class="text-success">
                                                Admission : Confirmed
                                            </span>
                                        @elseif($allotment->valid)
                                            <span class="text-warning">
                                                Admission : Pending
                                            </span>
                                        @else
                                            <span class="text-danger">
                                                Admission : Declined
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($allotment->application)
                                            {{ App\Models\Room::room_type($allotment->application->roomtype) }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    {{-- <td>

                                            <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/admission/create?sessn_id={{ $sessn->id }}">Options</a>
                                        </td> --}}
                                    <td>
                                        <div class="btn-group">
                                            @if ($allotment->valid)
                                                @if (
                                                    $allotment->valid_allot_hostel() &&
                                                        ($allotment->valid_allot_hostel()->valid_allot_seat() ||
                                                            $allotment->valid_allot_hostel()->hostel->id != $allotment->hostel->id))
                                                    <button class="btn btn-primary btn-sm btn-allot-seat"
                                                        value="{{ $allotment->id }}" disabled>Allot seat</button>
                                                @else
                                                    <button class="btn btn-primary btn-sm btn-allot-seat"
                                                        value="{{ $allotment->id }}">Allot seat</button>
                                                @endif
                                                @if ($allotment->valid_allot_hostel() && $allotment->confirmed == 0)
                                                    <button class="btn btn-secondary btn-sm btn-admission"
                                                        value="{{ $allotment->id }}">Admit</button>
                                                @else
                                                    <button class="btn btn-secondary btn-sm btn-admission"
                                                        value="{{ $allotment->id }}" disabled>Admit</button>
                                                @endif
                                                <button class="btn btn-danger btn-sm btn-decline"
                                                    value="{{ $allotment->id }}">Decline</button>
                                            @else
                                                Invalid
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </x-block>
    </x-container>

    {{-- Modal for seat allotment --}}


    <div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatModalLabel">Assign seat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 form-group">
                        <div class="col">
                            <label for="seat">Seat No.:</label>
                        </div>
                        <div class="col">
                            <select class="form-control" id="seat" name="seat">

                            </select>
                            <input class="form-check-input" type="checkbox" value="1" id="available" checked>
                            <label class="form-check-label" for="available">
                                Show only available rooms/seats
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary btn-approve" value="approve-seat">Approve
                        seat</button>

                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for seat allotment --}}

    {{-- Modal for admission --}}


    <div class="modal fade" id="admissionModal" tabindex="-1" aria-labelledby="admissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="admissionModalLabel">Assign admission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label for="sessn" class="col">Starting session (in the hostel)</label>
                        <div class="col">

                            <select class="form-control" name="sessn">
                                @foreach (App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get() as $ssn)
                                    <option value="{{ $ssn->id }}"
                                        {{ $allotment->start_sessn_id == $ssn->id ? ' selected ' : '' }}>
                                        {{ $ssn->name() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="amount" class="col">Payment amount</label>
                        <div class="col">
                            <input type="text" class="form-control" name="amount" value="">
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="dt" class="col">Payment date</label>
                        <div class="col">
                            <input type="date" class="form-control" name="dt" value="{{ old('dt') }}"
                                required>
                            @error('dt')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-add-admission" value="add-admission">Approve
                        admission</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for admission --}}

    {{-- Modal for declining --}}


    <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">Decline admission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 form-group">
                        <label for="remark" class="col">Reason for cancellation</label>
                        <div class="col">
                            <textarea name="remark" class="form-control"></textarea>
                            @error('remark')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-confirm-decline"
                        value="decline">Decline</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for declining --}}


    <script>
        function load_seats() {
            $.ajax({
                type: "get",
                url: "/ajax/get_all_seats?hostel_id={{ $allotment->hostel->id }}",
                success: function(data, status) {
                    var s = "<option value='0'>Select Seat</option>";

                    for (i = 0; i < data.length; i++) {
                        if ({{ old('seat', 0) }} == data[i].id) {
                            s += "<option value='" + data[i].id + "' selected>Seat: " + data[i].serial +
                                " of " + data[i].roomno + "(" + data[i].room_type + ")</option>";
                        } else {
                            s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i]
                                .roomno + "(" + data[i].room_type + ")</option>";
                        }

                    }
                    $("select[id='seat']").html(s);
                    //alert(data[0].roomno);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    alert("Error");
                }
            });
        }

        function load_available_seats() {
            $.ajax({
                type: "get",
                url: "/ajax/get_available_seats?hostel_id={{ $allotment->hostel->id }}",
                success: function(data, status) {
                    var s = "<option value='0'>Select Seat</option>";
                    for (i = 0; i < data.length; i++) {
                        if ({{ old('seat', 0) }} == data[i].id) {
                            s += "<option value='" + data[i].id + "' selected>Seat: " + data[i].serial +
                                " of " + data[i].roomno + "(" + data[i].room_type + ")</option>";
                        } else {
                            s += "<option value='" + data[i].id + "'>Seat: " + data[i].serial + " of " + data[i]
                                .roomno + " (" + data[i].room_type + ")</option>";
                        }
                    }
                    $("select[id='seat']").html(s);
                    //alert(data[0].roomno);
                },
                error: function() {
                    alert("Error");
                }
            });
        }

        load_available_seats();

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-allot-seat").click(function() {
                $("input#allotment_id").val($(this).val());
                $("input#available").prop("checked", true);
                load_available_seats();
                $("div#seatModal").modal("show");
            });

            $("button.btn-approve").click(function() {
                if ($("select[name='seat']").val() == 0 || $("input[name='seat']").val() == "") {
                    alert("Please select the seat");
                    exit();
                } else {
                    $.ajax({
                        url: "/ajax/allotment/" + $("input#allotment_id").val() +
                            "/allot_hostel/store",
                        type: "post",
                        data: {
                            seat: $("select[name='seat']").val()
                        },
                        success: function(data, status) {
                            alert("Successful");
                            location.reload();
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }
                // alert($(this).val());
            });

            $("button.btn-admission").click(function() {
                $("input#allotment_id").val($(this).val());
                $("div#admissionModal").modal("show");
            });

            $("button.btn-add-admission").click(function() {
                // alert(typeof $("input[name='amount']").val());
                if ($("input[name='amount']").val() == '' || $("input[name='dt']").val() == '') {
                    alert("Enter correct amount and date");
                    exit();
                } else {
                    $.ajax({
                        url: "/ajax/allotment/" + $("input#allotment_id").val() +
                            "/admission/store",
                        type: "post",
                        data: {
                            sessn_id: $("select[name=sessn]").val(),
                            amount: $("input[name='amount']").val(),
                            payment_dt: $("input[name='dt']").val(),
                        },
                        success: function(data, status) {
                            if (data == "Successful") {
                                alert(data);
                                location.reload();
                            } else {
                                alert(data);
                            }

                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }

                // alert("hehe");
            });

            $("button.btn-decline").click(function() {
                // alert($(this).val());
                if ($(this).val() == 0) {
                    alert(
                        "Once students done admission, please cancel seat using proper seat cancellation procedure."
                    );
                    exit();
                } else {
                    $("input#allotment_id").val($(this).val());
                    $.ajax({
                        type: "get",
                        url: "/ajax/allotment/" + $(this).val() + "/application",
                        success: function(data, status) {
                            $("textarea[name='remark']").val(data.remark);
                            // alert(data.application_id);
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                    $("#declineModal").modal("show");
                }
            });

            $("button.btn-confirm-decline").click(function() {
                $.ajax({
                    type: "post",
                    url: "/ajax/allotment/" + $("input#allotment_id").val() + "/decline",
                    data: {
                        remark: $("textarea[name='remark']").val()
                    },
                    success: function(data, status) {
                        alert(data);
                        location.reload();
                    },
                    error: function() {
                        alert("Error");
                    }
                });
            });

            $("input[name='find']").on("keyup", function() {
                var pattern = $(this).val();

                $("table tr").each(function(index) {
                    if (index != 0) {
                        $row = $(this);
                        var text = $row.find("td.name").text().toLowerCase().trim();
                        if (text.match(pattern)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }
                });
            });

            $("input#available").click(function() {
                if ($(this).prop('checked')) {
                    load_available_seats();
                } else {
                    load_seats();
                }
            });
        });
    </script>
</x-layout>
