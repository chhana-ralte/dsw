<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of all Wardens
            </x-slot>


            @if (count($wardens) > 0)
                <table class="table">
                    <tr>
                        <th>Hostel</th>
                        <th>Warden</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>

                    @foreach ($wardens as $wd)
                        <tr>
                            <td>{{ $wd->hostel->name }}</td>
                            <td>{{ $wd->person->name }}</td>
                            <td>{{ $wd->from_dt }}</td>
                            <td>{{ $wd->to_dt }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </x-block>
    </x-container>
</x-layout>
