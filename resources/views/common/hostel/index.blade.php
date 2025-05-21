<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ __('Halls of Residence in Mizoram University') }}
            </x-slot>
            @if (count($hostels) > 0)
                <div style="width: 100%; overflow-x: auto; ;">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Hostel name</th>
                                <th>Gender</th>
                                <th>Total seats</th>
                                <th>Available seats</th>
                                <th>Filled</th>
                                <th>Vacant</th>
                            <tr>
                        </thead>
                        <tbody>
                            <?php
                                $sl = 1;
                                $total = $available = $filled = 0;
                            ?>
                            @foreach ($hostels as $h)
                                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                    <td>{{ $sl++ }}</td>
                                    @can('view',$h)
                                        <td><a href="/hostel/{{ $h->id }}">{{ $h->name }}</a></td>
                                    @else
                                        <td>{{ $h->name }}</td>
                                    @endcan
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
                            <th></th>
                                <th>Total</th>
                                <th></th>
                                <th>{{ $total }}</th>
                                <th>{{ $available }}</th>
                                <th>{{ $filled }}</th>
                                <th>{{ $vacant }}</th>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                No Hostel available
            @endif
        </x-block>
    </x-container>
</x-layout>
