<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                <div class="flex justify-between">
                    <div class="col">
                        Rooms in {{ $hostel->name }} Hall of Residence
                    </div>
                    <div class="col-auto">
                        <div class="relative">
                            <button id="filterDropdown" type="button"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline dropdown-toggle"
                                aria-expanded="false" aria-controls="filterDropdownMenu">
                                Filter
                            </button>
                            <ul class="absolute z-10 hidden bg-white shadow rounded-md py-1 text-sm text-gray-700 list-none"
                                aria-labelledby="filterDropdown">
                                <li><a class="block px-4 py-2 hover:bg-gray-100"
                                        href="/hostel/{{ $hostel->id }}/room">All rooms</a></li>
                                <li><a class="block px-4 py-2 hover:bg-gray-100"
                                        href="/hostel/{{ $hostel->id }}/room?status=vacant">Vacant
                                        rooms/seats</a></li>
                                <li><a class="block px-4 py-2 hover:bg-gray-100"
                                        href="/hostel/{{ $hostel->id }}/room?status=non-available">Non-available
                                        rooms/seats</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-2">
                    <div class="col-auto">
                        <a class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold py-2 px-3 rounded"
                            href="/hostel/{{ $hostel->id }}">back</a>
                    </div>
                    @auth
                        @if (auth()->user()->isWardenOf($hostel->id))
                            <div class="col-auto">
                                <a class="bg-secondary-500 hover:bg-secondary-700 text-white text-sm font-bold py-2 px-3 rounded"
                                    href="/hostel/{{ $hostel->id }}/room/create">Create
                                    new room</a>
                            </div>
                        @endif
                    @endauth
                </div>

            </x-slot>

            @if (count($rooms) > 0)
                <div class="w-full overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">Room No</th>
                                <th class="px-4 py-2 border">Capacity</th>
                                <th class="px-4 py-2 border">Available</th>
                                <th class="px-4 py-2 border">Filled</th>
                                <th class="px-4 py-2 border">Vacancy</th>
                                <th class="px-4 py-2 border">Remarks</th>
                                @auth
                                    @can('update', $hostel)
                                        <th class="border">Manage</th>
                                    @endcan
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            <?php
                            $capacity = 0;
                            $available = 0;
                            $filled = 0;
                            ?>
                            @foreach ($rooms as $r)
                                <?php
                                $capacity += $r->capacity;
                                $available += $r->available;
                                $filled += $r->filled()->count();
                                ?>
                                <tr class="{{ $r->capacity == $r->available ? 'bg-gray-100' : 'bg-red-100' }}">
                                    <td class="border px-4 py-2"><a href="/room/{{ $r->id }}"
                                            class="text-blue-500 hover:underline">{{ $r->roomno }}</a></td>
                                    <td class="border px-4 py-2">{{ $r->capacity }}</td>
                                    <td class="border px-4 py-2">{{ $r->available }}</td>
                                    <td class="border px-4 py-2">{{ $r->filled()->count() }}</td>
                                    <td class="border px-4 py-2">{{ $r->available - $r->filled()->count() }}</td>
                                    <td class="border px-4 py-2">
                                        @if (count($r->remarks))
                                            <ul class="list-disc pl-5">
                                                @foreach ($r->remarks as $rm)
                                                    <li>{{ \Carbon\Carbon::parse($rm->remark_dt)->format('Y-m-d') }}:
                                                        {{ $rm->remark }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    @auth
                                        @can('update', $r->hostel)
                                            <td class="border px-4 py-2 relative">
                                                <div class="relative">
                                                    <button
                                                        class="bg-secondary-500 hover:bg-secondary-700 text-black font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline dropdown-toggle"
                                                        type="button" id="manageDropdown{{ $r->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        ...
                                                    </button>
                                                    <ul class="absolute z-20 right-0 mt-2 w-32 bg-white shadow rounded-md py-1 text-sm text-gray-700 list-none hidden"
                                                        id="manageDropdownMenu{{ $r->id }}"
                                                        aria-labelledby="manageDropdown{{ $r->id }}">
                                                        <li><a class="block px-4 py-2 hover:bg-gray-100"
                                                                href="/room/{{ $r->id }}/remark">Remark</a></li>
                                                        <li><a class="block px-4 py-2 hover:bg-gray-100"
                                                                href="/room/{{ $r->id }}/edit">Edit Room</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        @endcan
                                    @endauth
                                </tr>
                            @endforeach
                            <tr class="bg-white">
                                <th class="px-4 py-2 border">Total</th>
                                <th class="px-4 py-2 border">{{ $capacity }}</th>
                                <th class="px-4 py-2 border">{{ $available }}</th>
                                <th class="px-4 py-2 border">{{ $filled }}</th>
                                <th class="px-4 py-2 border">{{ $available - $filled }}</th>
                                <th class="px-4 py-2 border"></th>
                                @auth
                                    @can('update', $hostel)
                                        <th class="px-4 py-2 border"></th>
                                    @endcan
                                @endauth
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-4">No Room available</div>
            @endif
        </x-block>

    </x-container>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterDropdownButton = document.getElementById('filterDropdown');
        const filterDropdownMenu = filterDropdownButton.nextElementSibling;

        filterDropdownButton.addEventListener('click', function() {
            filterDropdownMenu.classList.toggle('hidden');
        });

        // Close the dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!filterDropdownButton.contains(event.target) && !filterDropdownMenu.contains(event
                    .target)) {
                filterDropdownMenu.classList.add('hidden');
            }
        });

        // Manage dropdown functionality
        const manageDropdownButtons = document.querySelectorAll('[id^="manageDropdown"]');
        manageDropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const roomId = this.id.replace('manageDropdown', '');
                const menu = document.getElementById(`manageDropdownMenu${roomId}`);
                menu.classList.toggle('hidden');
            });
        });

        // Close manage dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            manageDropdownButtons.forEach(button => {
                const roomId = button.id.replace('manageDropdown', '');
                const menu = document.getElementById(`manageDropdownMenu${roomId}`);
                if (!button.contains(event.target) && menu && !menu.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    });
</script>
