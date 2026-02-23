<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                List of students in the Hostel in the {{ $sessn->name() }}
                <p>
                    <button class="btn btn-secondary btn-sm" onclick="history.back()">
                        back
                    </button>
                </p>
            </x-slot>
            <form method="post" action="/hostel/{{ $hostel->id }}/semfee/confirmall">
                @csrf
                <input type="hidden" name="sessn_id" value="{{ $sessn->id }}">
                <input type="hidden" name="hostel_id" value="{{ $hostel->id }}">
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                    <?php $sl=1 ?>
                    @foreach($allot_hostels as $ah)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>
                                <a href="/allot_hostel/{{ $ah->id }}/semfee/create?sessn_id={{ $sessn->id }}">{{ $ah->allotment->person->name }}<a>

                            </td>
                            <td>
                                {{ $ah->valid_room() }}
                            </td>
                            <td>
                                <select name="capacity_{{ $ah->id }}">
                                    <option disables readonly>Select room capacity</option>
                                    <option value="1" {{ $ah->room_capacity() == 1?' selected ':'' }}>Single</option>
                                    <option value="2" {{ $ah->room_capacity() == 2?' selected ':'' }}>Double</option>
                                    <option value="3" {{ $ah->room_capacity() == 3?' selected ':'' }}>Triple</option>
                                    <option value="4" {{ $ah->room_capacity() == 4?' selected ':'' }}>Dorm</option>
                                </option>

                            </td>
                            <td>
                                {{ $ah->semfee($sessn->id)? $ah->semfee($sessn->id)->status : 'Nothing' }}
                            </td>
                        </tr>
                    @endforeach
                    @can('manage_semfee', $ah)
                    <tr>
                        <td colspan=4>
                            <button type="submit" class="btn btn-primary btn-submit">Confirm</button>
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
                $(this).prop('checked',$("input#all").prop("checked"));
            });
        });

        $("button.btn-submit").click(function(){

        });



    });

</script>
</x-layout>
