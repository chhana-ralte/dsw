<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                Select the Hostel
                <p>
                    <a class="btn btn-primary btn-sm" href="/section/create">
                        asdasd
                    </a>
                </p>
            </x-slot>
            <table class="table">
                <tr>
                    <th>Sl</th>
                    <th>Hostel</th>
                    <th>Gender</th>
                </tr>
                <?php $sl=1 ?>
                @foreach(\App\Models\Hostel::orderBy('gender')->get() as $h)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>
                            <a href="/semfee?hostel_id={{ $h->id }}">{{ $h->name }}</a>

                        </td>
                        <td>
                            {{ $h->gender }}

                        </td>
                    </tr>
                @endforeach
            </table>
        </x-block>
    </x-container>
</x-layout>
