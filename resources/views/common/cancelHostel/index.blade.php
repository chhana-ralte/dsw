<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seats cancelled from {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-primary btn-sm"
                        href="/hostel/{{ $hostel->id }}/admission?sessn={{ App\Models\Sessn::default()->id }}">Admission
                        details</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-striped">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>Date of Leaving</th>
                            <th>Clearance?</th>
                        </tr>
                        @foreach ($cancel_seats as $cs)
                            <tr>
                                <td><a href="/allotment/{{ $cs->allotment_id }}">{{ $cs->allotment->person->name }}</a>
                                </td>
                                @if ($cs->allotment->person->student())
                                    <td>{{ $cs->allotment->person->student()->course }}</td>
                                    <td>{{ $cs->allotment->person->student()->department }}</td>
                                @elseif($cs->allotment->person->other())
                                    <td colspan="2">{{ $cs->allotment->person->other()->remark }}</td>
                                @else
                                    <td colspan="2"><b>Unknown</b></td>
                                @endif

                                <td>
                                    {{ $cs->leave_dt }}
                                </td>
                                <td>
                                    @if ($cs->clearance)
                                        Clearance issued
                                    @else
                                        Clearance not issued
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $("button[name='btnClearance']").click(function() {
                // alert($(this).val());
                window.open("/cancelSeat/" + $(this).val(), 'Clearance');
            });
        });
    </script>
</x-layout>
