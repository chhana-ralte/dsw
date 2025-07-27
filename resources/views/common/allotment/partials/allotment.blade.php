<x-slot name="heading">
    Hostel allotment information
    @auth()
        @can('manage_self',$allotment)
            <a class="btn btn-secondary btn-sm"
                href="/allotment/{{ $allotment->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
        @endcan
    @endauth
</x-slot>
<table class="table">
    <tr>
        <td>Initial hostel allotted</td>
        <td>{{ $allotment->hostel->name }}</td>
    </tr>
    <tr>
        <td>Notification</td>
        <td>{{ $allotment->notification->no }} dated {{ $allotment->notification->dt }}</td>
    </tr>
    <tr>
        <td>Tentative allotment duration</td>
        <td>{{ $allotment->from_dt }} to {{ $allotment->to_dt }}</td>
    </tr>

    <tr>
        <td>Starting session</td>
        <td>
            @if($allotment->start_sessn())
                {{ $allotment->start_sessn()->name() }}
            @else
                Not defined
            @endif
        </td>
    </tr>

    <tr>
        <td>Expected ending session</td>
        <td>
            @if($allotment->end_sessn())
                {{ $allotment->end_sessn()->name() }}
            @else
                Not defined
            @endif
        </td>
    </tr>

    <tr>
        <td>Admission confirmed</td>
        <td>{{ $allotment->confirmed ? 'Yes' : 'No' }}</td>
    </tr>

    <tr>
        <td>Admission done?</td>
        <td>{{ $allotment->admitted ? 'Yes' : 'No' }}</td>
    </tr>
    <tr>
        <td>Allotment still valid?</td>
        <td>{{ $allotment->valid ? 'Yes' : 'No' }}</td>
    </tr>
    <tr>
        <td>Finished course and left?</td>
        <td>{{ $allotment->finished ? 'Yes' : 'No' }}</td>
    </tr>

</table>
