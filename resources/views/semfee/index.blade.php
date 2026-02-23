<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                List of students in the Hostel in the {{ $sessn->name() }}
                {{-- <p>
                    <a class="btn btn-primary btn-sm" href="/section/create">
                        asdasd
                    </a>
                </p> --}}
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
                    @foreach($allot_hostels as $ah)
                        <tr>
                            <td>
                                @if($ah->allotment->person->email)
                                    <input type="checkbox" name="allot_hostel_id[]" value="{{ $ah->id }}">
                                @else
                                    <input type="checkbox" name="allot_hostel_id[]" value="{{ $ah->id }}" disabled>
                                @endif
                            </td>
                            <td>{{ $sl++ }}</td>
                            <td>
                                @if($ah->allotment->person->email)
                                    <a href="/allot_hostel/{{ $ah->id }}/semfee/create?sessn_id={{ $sessn->id }}">{{ $ah->allotment->person->name }}<a>
                                @else
                                    {{ $ah->allotment->person->name }}
                                @endif

                            </td>
                            <td>
                                {{ $ah->valid_room() }}
                            </td>
                            <td>
                                {{ \App\Models\Room::room_type($ah->room_capacity()) }}
                            </td>
                            <td>
                                @if(!$ah->allotment->person->email)
                                    <span class="text-danger">No Email</span>
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
                    @endforeach
                    @can('manage_semfee', $ah)
                    <tr>
                        <td colspan=4>
                            <button class="btn btn-primary">Submit all</button>
                        </td>
                    </tr>
                    @endcan
                </table>
            </form>
        </x-block>
    </x-container>
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


    });

</script>
</x-layout>
