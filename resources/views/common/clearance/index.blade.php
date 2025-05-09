<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Clearance details for 
                <select name="hostel">
                    @foreach(App\Models\Hostel::all() as $h)
                        <option value="{{ $h->id }}" {{ $h->id == $hostel->id?' selected ':'' }}>{{ $h->name }}</option>
                    @endforeach
                </select>
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <thead>
                        <tr>
                            <th>Seat No.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cancel_seats as $cs)
                            <tr>
                            <td>
                                @if($cs->allot_seat)
                                    {{ $cs->allot_seat->seat->room->roomno }}/{{ $cs->allot_seat->seat->serial }}
                                @endif
                            </td>
                            <td>
                                {{ $cs->allotment->person->name }}
                            </td>
                            @if($cs->allotment->person->student())
                                <td>
                                    {{ $cs->allotment->person->student()->course }}
                                </td>
                                <td>
                                    {{ $cs->allotment->person->student()->department }}
                                </td>
                                <td>
                                    {{ $cs->allotment->person->student()->mzuit }}
                                </td>
                            @else
                                <td colspan=3>Not a student</td>
                            @endif
                            
                        </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </x-block>

    </x-container>
<script>
$(document).ready(function(){
    $("select[name='hostel']").change(function(){
        location.replace("/hostel/" + $(this).val() + "/clearance");
        // alert($(this).val());
    });
});
</script>
</x-layout>
