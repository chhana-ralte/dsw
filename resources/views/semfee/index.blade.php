<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                List of students currently in the Hostel in the {{ $sessn->name() }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/semfee/list/hostel">
                        Back
                    </a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form name='frmMain' method="post" action="/hostel/{{ $hostel->id }}/semfee/approveall">
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
                        @foreach($allot_hostels as $ah)
                            @if($ah->allotment->sessn_id != $sessn->id)
                                <tr>
                                    <td class="check">
                                        @if($ah->allotment->person->email && !$ah->semfee($sessn->id) && $ah->valid_allot_seat())
                                            <input type="checkbox" name="allot_hostel_id[]" value="{{ $ah->id }}">
                                        @else
                                            <input type="checkbox" name="allot_hostel_id[]" value="{{ $ah->id }}" disabled>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->isDsw())
                                            <a href="#">{{ $sl++ }}</a>
                                        @else
                                            {{ $sl++ }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($ah->allotment->person->email && $ah->valid_allot_seat())
                                            <a href="/allot_hostel/{{ $ah->id }}/semfee/create?sessn_id={{ $sessn->id }}">{{ $ah->allotment->person->name }}<a>
                                        @else
                                            {{ $ah->allotment->person->name }}
                                        @endif

                                    </td>
                                    @if($ah->valid_allot_seat())
                                        <td>
                                            {{ $ah->valid_room() }}
                                        </td>
                                        <td>
                                            {{ \App\Models\Room::room_type($ah->room_capacity()) }}
                                        </td>
                                    @else
                                        <td colspan="2">
                                            <span class="text-warning">No valid room</span>
                                        </td>
                                    @endif
                                    <td>
                                        @if(!$ah->allotment->person->email)
                                            <button type="button" class="email-update" value="{{ $ah->allotment->person->id }}">
                                                <span class="text-danger">No Email</span>
                                            </button>
                                        @else
                                            {{ $ah->semfee($sessn->id)? $ah->semfee($sessn->id)->status : 'Null' }}
                                        @endif
                                        @if(auth()->user() && auth()->user()->isFinance() && $ah->semfee($sessn->id) && $ah->semfee($sessn->id)->status == 'Created')
                                            <a href="#" class="btn btn-sm btn-primary">
                                                Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @can('manage_semfee', $ah)
                        <tr>
                            <td colspan=4>
                                <button type="button" class="btn btn-primary btn-submit-all">Submit selected</button>
                            </td>
                        </tr>
                        @endcan
                    </table>
                </form>
            </div>
        </x-block>

    </x-container>
{{-- Modal for email update --}}
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Add email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <input type="hidden" name="person_id" value="">
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input class="form-control" type="email" name="email" id="email" required>{{ old('email') }}</input>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="col-form-label">Mobile:</label>
                            <input class="form-control" type="number" name="mobile" id="mobile" required>{{ old('mobile') }}</input>
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
    {{-- End Modal for email update --}}
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            }
        });

        $.validator.addMethod("mobileRU", function(value, element) {
            return this.optional(element) || /^[0-9]{10}$/.test(value);
        }, "Please enter a valid 10-digit mobile number");

        $("#updateForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true // Built-in email validation [2]
                },
                mobile: {
                    required: true,
                    mobileRU: true // Custom mobile validation
                }
            },
            messages: {
                email: "Please enter a valid email address",
                mobile: "Please enter a valid 10-digit phone number"
            }
        });

        $('.table tr td.check').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $("input#all").click(function(){
            $("input[name='allot_hostel_id[]']").each(function(){
                if($(this).prop('disabled') == false){
                    $(this).prop('checked',$("input#all").prop("checked"));
                }
            });
        });

        $(".btn-submit-all").click(function(){
            if($("input[name='allot_hostel_id[]']:checked").length == 0)
            {
                alert("Select the list of students...");
            }
            else{
                $("form[name='frmMain']").submit();
            }
        });

        $(".email-update").click(function(){
            $("input[name='person_id']").val($(this).val());
            // alert($("input[name='person_id']").val());
            $.ajax({
                type : 'get',
                url : '/ajax/person/' + $(this).val() + '/getEmail',
                success : function(data, status){
                    $("input[name='email']").val(data.email);
                    $("input[name='mobile']").val(data.mobile);
                },
                error: function(){
                    alert('Error');
                }
            });
            $("#emailModal").modal("show");
        });

        $(".btn-update").click(function(){
            if($("#updateForm").valid()){
                $.ajax({
                    type : 'post',
                    url : '/ajax/person/' + $("input[name='person_id']").val() + '/updateEmail',
                    data : {
                        email : $("input[name='email']").val(),
                        mobile : $("input[name='mobile']").val()
                    },
                    success : function(data, status){
                        alert("Successful");
                        location.reload();
                    },
                    error: function(){
                        alert('Error');
                    }
                });
            }
        });
    });

</script>
</x-layout>
