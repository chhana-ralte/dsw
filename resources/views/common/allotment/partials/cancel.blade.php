<x-slot name="heading">
    Seat cancelled...
</x-slot>
<table class="table">
    <tr>
        <td>Last hostel from where cancelled</td>
        <td>{{ $allotment->cancel_seat->allot_hostel->hostel->name }}</td>
    </tr>
    <tr>
        <td>Last hostel room</td>
        <td>
            @if($allotment->cancel_seat->allot_seat)
                {{ $allotment->cancel_seat->allot_seat->seat->room->roomno }}
            @else
                Not available
            @endif
        </td>
    </tr>
    <tr>
        <td>Date of actual leaving/tentative leaving date</td>
        <td>{{ $allotment->cancel_seat->leave_dt }}</td>
    </tr>
    <tr>
        <td>Date of issuance</td>
        <td>{{ $allotment->cancel_seat->issue_dt }}</td>
    </tr>
    <tr>
        <td>Whether clearance can be given?</td>
        <td>{{ $allotment->cancel_seat->cleared ? 'Yes' : 'No' }}</td>
    </tr>
    @if ($allotment->cancel_seat->cleared == 0)
        <tr>
            <td>Amount due</td>
            <td>{{ $allotment->cancel_seat->outstanding }}</td>
        </tr>
    @endif
    <tr>
        <td>Whether approved by DSW?</td>
        <td>{{ $allotment->valid ? 'Not yet' : 'Yes' }}</td>
    </tr>
    <tr>
        <td>Whether course completed?</td>
        <td>{{ $allotment->cancel_seat->finished ? 'Yes' : 'No' }}</td>
    </tr>
</table>
