<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ __('Halls of Residence in Mizoram University') }}
            </x-slot>
            @if(count($hostels)>0)
                <table class="table table-hover table-auto table-striped">
                    <thead>
                        <tr>
                        <th>Hostel name</th><th>Gender</th><th>Total seats</th><th>Available seats</th><th>Filled</th><th>Vacant</th><tr>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total = $available = $filled = 0;
                        ?>
                        @foreach($hostels as $h)
                        <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                            <td><a href="/hostel/{{ $h->id }}">{{ $h->name }}</a></td>
                            <td>{{ $h->gender }}</td>
                            <td>{{ $h->capacity() }}</td>
                            <td>{{ $h->available() }}</td>
                            <td>{{ $h->filled() }}</td>
                            <td>{{ $h->vacant() }}</td>
                        </tr>
                        <?php
                            $total += $h->capacity();
                            $available += $h->available();
                            $filled += $h->filled();
                        ?>
                        @endforeach
                        <?php $vacant = $available - $filled; ?>
                        <tr>
                            <th>Total</th><th></th><th>{{ $total }}</th><th>{{ $available }}</th><th>{{ $filled }}</th><th>{{ $vacant }}</th><tr>
                        </tr>
                    </tbody>
                </table>
            @else
                No Hostel available
            @endif
        </x-block>
    </x-container>
</x-layout>
