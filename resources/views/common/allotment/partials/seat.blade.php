<x-slot name="heading">
    Seat Allotment Information
</x-slot>
@if (count($allotment->allot_hostels) > 0)
    @foreach ($allotment->allot_hostels as $ah)
        <b>{{ $ah->hostel->name }}</b> ({{ $ah->valid ? 'Valid' : 'Invalid' }})<br>
        @foreach ($ah->allot_seats as $as)
            {{ $as->seat->room->roomno }}/{{ $as->seat->serial }}
            ({{ $as->valid ? 'Valid' : 'Invalid' }})
            <br>
        @endforeach
        <hr>
    @endforeach
@endif

@auth
    @if ($allotment->valid_allot_hostel())
        @can('edit', $allotment)
            <a class="btn btn-primary"
                href="/allot_hostel/{{ $allotment->valid_allot_hostel()->id }}/allotSeat">Change room/seat</a>
            <a class="btn btn-danger" href="/allotment/{{ $allotment->id }}/cancelSeat/create">Cancel the seat</a>
        @endcan
        @if (auth()->user()->isDsw())
            <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot another
                hostel</a>
        @endif
    @else
        @if (auth()->user()->isDsw())
            <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/allot_hostel/create">Allot
                hostel</a>
        @endif
    @endif

    @if (auth()->user()->isAdmin())
        <button class="btn btn-danger" form="clear_allotment">Clear allotment info</button>
        <form id="clear_allotment" type="hidden" method="post"
            action="/allotment/{{ $allotment->id }}/clear_allotment"
            onsubmit="return confirm('Are you sure you want to clear all allotment details?')">
            @csrf
        </form>
    @endif
@endauth
