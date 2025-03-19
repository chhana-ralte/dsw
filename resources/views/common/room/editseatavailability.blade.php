<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Seats in {{ $room->roomno }} of {{ $room->hostel->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/room/{{ $room->id }}">back</a>
                </p>
            </x-slot>
            <form id="update" method="post" action="/room/{{ $room->id }}/editseatavailability">
                @csrf
                <table class="table table-hover table-auto table-striped">
                    <tbody>
                        <tr><th>Seat No.</th><th>Available</th></tr>
                        @foreach($seats as $s)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td>{{ $room->roomno }}/{{ $s->serial }}</td>
                            <td>
                                <input type="hidden" name="available_{{ $s->id }}" value="0">
                                <input type="checkbox" name="available_{{ $s->id }}" {{ $s->available ? ' checked ':'' }} value="1">
                                
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary">Update</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

});
</script>
</x-layout>
