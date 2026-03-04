<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                List of students in the Hostel in the {{ $sessn->name() }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/semfee/list/hostel">
                        Back
                    </a>
                    <a class="btn btn-primary btn-sm" href="/semfee/list/hostel/{{ $hostel->id }}/Null">
                        Null
                    </a>
                    <a class="btn btn-primary btn-sm" href="/semfee/list/hostel/{{ $hostel->id }}/Forwarded">
                        Forwarded
                    </a>
                    <a class="btn btn-primary btn-sm" href="/semfee/list/hostel/{{ $hostel->id }}/Sent">
                        Sent
                    </a>
                    <a class="btn btn-primary btn-sm" href="/semfee/list/hostel/{{ $hostel->id }}/Paid">
                        Paid
                    </a>
                    <a class="btn btn-primary btn-sm" href="/semfee/list/hostel/{{ $hostel->id }}/Cancelled">
                        Cancelled
                    </a>
                </p>
            </x-slot>
            <form method="post" action="/hostel/{{ $hostel->id }}/semfee/approveall">
                @csrf
                <input type='hidden' name="sessn_id" value="{{ $sessn->id }}">
                <table class="table">
                    <tr>
                        <th><input type="checkbox" id="all"></th>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                    <?php $sl=1 ?>
                    @foreach($semfees as $sf)
                        <tr>
                            <td>
                                @if($sf->allot_hostel->allotment->person->email)
                                    <input type="checkbox" name="allot_hostel_id[]" value="{{ $sf->allot_hostel->id }}">
                                @else
                                    <input type="checkbox" name="allot_hostel_id[]" value="{{ $sf->allot_hostel->id }}" disabled>
                                @endif
                            </td>
                            <td>{{ $sl++ }}</td>
                            <td>
                                @if($sf->allot_hostel->allotment->person->email)
                                    <a href="/allot_hostel/{{ $sf->allot_hostel->id }}/semfee/create?sessn_id={{ $sessn->id }}">{{ $sf->allot_hostel->allotment->person->name }}<a>
                                @else
                                    {{ $sf->allot_hostel->allotment->person->name }}
                                @endif

                            </td>
                            <td>
                                {{ $sf->allot_hostel->valid_room() }}
                            </td>
                            <td>
                                {{ \App\Models\Room::room_type($sf->allot_hostel->room_capacity()) }}
                            </td>
                            <td>
                                @if(auth()->user() && auth()->user()->isFinance())
                                    <button type="button" class="email-update" value="{{ $sf->id }}">
                                        <span class="text-danger">{{ $sf->status }}</span>
                                    </button>
                                @else
                                    {{ $sf->status }}
                                @endif
                                @if(auth()->user() && auth()->user()->isFinance() && $sf->allot_hostel->semfee($sessn->id) && $sf->allot_hostel->semfee($sessn->id)->status == 'Forwarded')
                                    <button type="button" class="btn btn-sm btn-primary detail" value="{{ $sf->id }}">
                                        Detail
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
            </form>
        </x-block>

    </x-container>
{{-- Modal for status update --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Add status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="semfee_id" value="">
                        <div class="mb-3">
                            <label for="status" class="col-form-label">Change status to :</label>
                            <input class="form-control mb-3" type="status" name="status">{{ old('status') }}</input>
                            <button class="btn btn-primary mb-3" name="status">Click here to change status to "Sent"</button>
                            <button class="btn btn-primary mb-3" name="status">asdasdasdad asda sda</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-update">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for status update --}}


    {{-- Modal for finance printing --}}

    <div class="modal fade" id="financeModal" tabindex="-1" aria-labelledby="financeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="financeModalLabel">Brief allotment information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="width: 100%; overflow-x:auto">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td>
                                    <span id="name"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>email</th>
                                <td>
                                    <span id="email"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>
                                    <span id="mobile"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Course</th>
                                <td>
                                    <span id="course"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td>
                                    <span id="semester"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>MZU ID</th>
                                <td>
                                    <span id="mzuid"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Hostel</th>
                                <td>
                                    <span id="hostel"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Room type</th>
                                <td>
                                    <span id="room_type">dfsfsf</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span id="status">dfsfsf</span>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- End Modal for finance printing --}}



<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            }
        });

        // $('.table tr').click(function(event) {
        //     if (event.target.type !== 'checkbox') {
        //         $(':checkbox', this).trigger('click');
        //     }
        // });

        $("input#all").click(function(){
            $("input[name='allot_hostel_id[]']").each(function(){
                if($(this).prop('disabled') == false){
                    $(this).prop('checked',$("input#all").prop("checked"));
                }

            });
        });

        $("button.detail").click(function(){
            // alert($(this).val());
            $.ajax({
                type : 'get',
                url : '/ajax/semfee/' + $(this).val() + '/getDetail',
                success : function(data, status){
                    $("span#name").text(data.name);
                    $("span#email").text(data.email);
                    $("span#mobile").text(data.mobile);
                    $("span#course").text(data.course);
                    $("span#mzuid").text(data.mzuid);
                    $("span#hostel").text(data.hostel);
                    $("span#room_type").text(data.room_type);
                    $("span#status").text(data.status);
                    $("#financeModal").modal("show");

                    //alert(data);
                },
                error : function(){
                    alert("Error");
                }
            })

            // $("input[name='person_id']").val($(this).val());
            // // alert($("input[name='person_id']").val());
            // $.ajax({
            //     type : 'get',
            //     url : '/ajax/person/' + $(this).val() + '/getEmail',
            //     success : function(data, status){
            //         $("input[name='email']").val(data);
            //     },
            //     error: function(){
            //         alert('Error');
            //     }
            // });
            // $("#emailModal").modal("show");
        });

        $(".btn-update").click(function(){
            $.ajax({
                type : 'post',
                url : '/ajax/person/' + $("input[name='person_id']").val() + '/updateEmail',
                data : {
                    email : $("input[name='email']").val()
                },
                success : function(data, status){
                    alert("Successful");
                    location.reload();
                },
                error: function(){
                    alert('Error');
                }
            });
        });


    });

</script>
</x-layout>
