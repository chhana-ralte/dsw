<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                List of students in the Hostel
                <p>
                    <a class="btn btn-primary btn-sm" href="/section/create">
                        asdasd
                    </a>
                </p>
            </x-slot>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Semester fee</th>
                </tr>
                <?php $sl=1 ?>
                @foreach($allot_hostels as $ah)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>
                            {{ $ah->allotment->person->name }}
                            
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-block>
    </x-container>
</x-layout>