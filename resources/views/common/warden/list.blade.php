<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of Wardens
            </x-slot>
            @if (count($wardens) > 0)
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr class="bg-gray-100 text-black dark:text-white">
                            <th class="px-4 py-2">Hostel</th>
                            <th class="px-4 py-2">Warden</th>
                            <th class="px-4 py-2">From</th>
                            <th class="px-4 py-2">To</th>
                            @if (auth() && auth()->user()->isAdmin())
                                <th class="px-4 py-2">User</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wardens as $wd)
                            <tr class="bg-white hover:bg-gray-100 text-gray-900">
                                <td class="border px-4 py-2">{{ $wd->hostel->name }}</td>
                                <td class="border px-4 py-2">{{ $wd->person->name }}</td>
                                <td class="border px-4 py-2">{{ $wd->from_dt }}</td>
                                <td class="border px-4 py-2">{{ $wd->to_dt }}</td>
                                @can('manage', $wd)
                                    <td class="border px-4 py-2">
                                        @if ($wd->user())
                                            <a href="/"
                                                class="text-blue-500 hover:underline">{{ $wd->user()->username }}</a>
                                        @else
                                            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm"
                                                href="/user/create?type=warden&id={{ $wd->id }}">Create user</a>
                                        @endif
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-block>
    </x-container>
</x-layout>
