<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Sessions
                <p>
                    <a href="/sessn/create"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Create
                        session</a>
                </p>
                <p class="text-sm">
                    <button form="create"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4  rounded-md ">Create
                        previous</button>
                    <button form="create"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4  rounded-md ">Create
                        next</button>
                </p>
            </x-slot>
            @if (count($sessns) > 0)
                <?php $sl = 1; ?>
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-black">
                            <th class="px-4 py-2 text-left">Sl.</th>
                            <th class="px-4 py-2 text-left">Session</th>
                            <th class="px-4 py-2 text-left">Whether current session?</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        @foreach ($sessns as $ssn)
                            <tr class="bg-white">
                                <td class="border px-4 py-2">{{ $sl++ }}</td>
                                <td class="border px-4 py-2">{{ $ssn->name() }}</td>
                                <td class="border px-4 py-2">{{ $ssn->current ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-block>
    </x-container>
</x-layout>
