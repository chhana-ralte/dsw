<x-slot name="heading">
    Remark(s) about student
</x-slot>
<table class="table table-auto">
    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
        <th>Date of incident</th>
        <th>Remark</th>
    </tr>
    @foreach ($allotment->person->person_remarks as $pr)
        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
            <td>{{ $pr->remark_dt }}</td>
            <td>
                <h4>{{ $pr->remark }}</h4>
                @if (count($pr->person_remark_details) > 0)
                    @foreach ($pr->person_remark_details as $prd)
                        <hr>
                        {{ $prd->detail }}
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
</table>
