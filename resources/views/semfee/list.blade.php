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
                                @if(auth()->user() && auth()->user()->isFinance() && $sf->allot_hostel->semfee($sessn->id) && $sf->allot_hostel->semfee($sessn->id)->status == 'Created')
                                    <a href="#" class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
            </form>
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
                    <form>
                        <input type="hidden" name="person_id" value="">
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input class="form-control" type="email" name="email">{{ old('email') }}</input>
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

        $('.table tr').click(function(event) {
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

        $(".email-update").click(function(){
            $("input[name='person_id']").val($(this).val());
            // alert($("input[name='person_id']").val());
            $.ajax({
                type : 'get',
                url : '/ajax/person/' + $(this).val() + '/getEmail',
                success : function(data, status){
                    $("input[name='email']").val(data);
                },
                error: function(){
                    alert('Error');
                }
            });
            $("#emailModal").modal("show");
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
