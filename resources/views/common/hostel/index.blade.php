<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ __('Halls of Residence in Mizoram University') }}
            </x-slot>

            @if (count($hostels) > 0)
                <div class="w-full overflow-x-auto">
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr class="bg-gray-100 text-black dark:text-white">
                                <th class="px-4 py-2">Sl.</th>
                                <th class="px-4 py-2">Hostel name</th>
                                <th class="px-4 py-2">Gender</th>
                                <th class="px-4 py-2">Total seats</th>
                                <th class="px-4 py-2">Available seats</th>
                                <th class="px-4 py-2">Filled</th>
                                <th class="px-4 py-2">Vacant</th>
                            <tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            $sl = 1;
                            $total = $available = $filled = 0;
                            ?>
                            @foreach ($hostels as $h)
                                <tr
                                    class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-sky-700 text-gray-900 dark:text-white">
                                    <td class="border px-4 py-2 text-black dark:text-gray-300">{{ $sl++ }}</td>
                                    <td class="border px-4 py-2"><a href="/hostel/{{ $h->id }}"
                                            class="text-sky-500 hover:underline">{{ $h->name }}</a></td>
                                    <td class="border px-4 py-2 text-black dark:text-gray-300">{{ $h->gender }}</td>
                                    <td class="border px-4 py-2 text-black dark:text-gray-300">{{ $h->capacity() }}</td>
                                    <td class="border px-4 py-2 text-black dark:text-gray-300">{{ $h->available() }}
                                    </td>
                                    <td class="border px-4 py-2 text-black dark:text-gray-300">{{ $h->filled() }}</td>
                                    <td class="border px-4 py-2 text-black dark:text-gray-300">{{ $h->vacant() }}</td>
                                </tr>
                                <?php
                                $total += $h->capacity();
                                $available += $h->available();
                                $filled += $h->filled();
                                ?>
                            @endforeach
                            <?php $vacant = $available - $filled; ?>
                            <tr class="bg-gray-100 font-semibold text-black dark:text-white">
                                <th class="px-4 py-2"></th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2"></th>
                                <th class="px-4 py-2">{{ $total }}</th>
                                <th class="px-4 py-2">{{ $available }}</th>
                                <th class="px-4 py-2">{{ $filled }}</th>
                                <th class="px-4 py-2">{{ $vacant }}</th>
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
