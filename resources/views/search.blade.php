<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Search
            </x-slot>
        </x-block>

        <x-block>
            <form method="get" action="/search">
                <div class="flex flex-wrap gap-2 md:flex-row">
                    <div class="w-full md:w-5/12">
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white"
                            type="text" name="str" value="{{ $str }}">
                    </div>
                    <div class="w-full md:w-3/12">
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            name="hostel">
                            <option value="0">All hostels</option>
                            @foreach (App\Models\Hostel::orderBy('name')->get() as $h)
                                <option value="{{ $h->id }}" {{ $hostel == $h->id ? ' selected ' : '' }}>
                                    {{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-3/12">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">Search</button>
                    </div>
                </div>
            </form>
        </x-block>

        @if (count($persons) > 0)
            <x-block>
                <x-slot name="heading">
                    Persons
                </x-slot>
                <div class="w-full overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Other info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($persons as $p)
                                <tr class="bg-white hover:bg-gray-100">
                                    <td class="border px-4 py-2">
                                        @if ($p->valid_allotment())
                                            @can('view', $p->valid_allotment())
                                                <a href="/allotment/{{ $p->valid_allotment()->id }}?back_link=/search?str={{ $str }}"
                                                    class="text-blue-500 hover:underline">{{ $p->name }}</a>
                                            @else
                                                {{ $p->name }}
                                            @endcan
                                        @else
                                            {{ $p->name }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if ($p->student())
                                            dept : {{ $p->student()->department }},
                                            course : {{ $p->student()->course }},
                                        @endif
                                        @if ($p->valid_allotment() && count($p->valid_allotment()->allot_hostels) > 0)
                                            (@foreach ($p->valid_allotment()->allot_hostels as $ah)
                                                hostel : {{ $ah->hostel->name }},
                                                stay : {{ $ah->valid ? 'Yes' : 'No' }},
                                            @endforeach)
                                            ,
                                        @endif
                                        @if ($p->other())
                                            {{ $p->other()->remark }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-block>
        @endif
    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
        });
    </script>
</x-layout>
