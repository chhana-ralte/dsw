<x-slot name="heading">
    Hostel admission details of the student
    @can('manage',$allotment)
        <p>
            <a class="btn btn-secondary btn-sm" href="/allotment/{{ $allotment->id }}/admission">Edit</a>
        </p>
    @endcan
</x-slot>


<span class="text-danger">
    If anything is to be updated, please contact the Warden
</span>


<table class="table table-auto">
    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
        <th>Session</th>
        <th>Admission status</th>
    </tr>
    @foreach(App\Models\Sessn::between_sessns($allotment->start_sessn(),App\Models\Sessn::current()) as $ssn)
        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
            <td>{{ $ssn->name() }}</td>
            <td>
                @if($allotment->admission($ssn->id))

                    <span class="text-success">Admission amount: {{ $allotment->admission($ssn->id)->amount }}</span><br>
                    <span class="text-success">Payment date: {{ $allotment->admission($ssn->id)->payment_dt }}</span>
                @else
                    <span class="text-warning">Not Done</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>
