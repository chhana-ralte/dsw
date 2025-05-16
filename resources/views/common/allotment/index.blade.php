<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Allotments under Notification {{ $notification->no }} dated {{ $notification->dt }}
                <p>
                    <a href="/notification/{{ $notification->id }}/allotment/create"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Create
                        new</a>
                </p>
            </x-slot>
            <div class="w-full overflow-x-auto">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-black">
                            <th class="px-4 py-2 text-left">Sl.</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Department</th>
                            <th class="px-4 py-2 text-left">Allotted Hostel</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        <?php $sl = 1; ?>
                        @foreach ($allotments as $allot)
                            <tr class="bg-white">
                                <td class="border px-4 py-2">{{ $sl++ }}</td>
                                <td class="border px-4 py-2"><a href="/allotment/{{ $allot->id }}"
                                        class="text-blue-500 hover:underline">{{ $allot->person->name }}</a></td>
                                @if ($allot->person->student())
                                    <td class="border px-4 py-2">{{ $allot->person->student()->course }}</td>
                                    <td class="border px-4 py-2">{{ $allot->person->student()->department }}</td>
                                @elseif($allot->person->other())
                                    <td colspan="2" class="border px-4 py-2">{{ $allot->person->other()->remark }}
                                    </td>
                                @else
                                    <td colspan="2" class="border px-4 py-2">Unknown</td>
                                @endif
                                <td class="border px-4 py-2">{{ $allot->hostel->name }}</td>
                                <td class="border px-4 py-2">
                                    Admission: {{ $allot->admitted ? 'Yes' : 'No' }},
                                    Valid: {{ $allot->valid ? 'Yes' : 'No' }},
                                    Left: {{ $allot->finished ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>
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
