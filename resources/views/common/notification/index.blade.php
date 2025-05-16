<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notifications
                <p>
                    <a href="/notification/create"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Create
                        new</a>
                </p>
            </x-slot>
            <div class="w-full overflow-x-auto">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-black">
                            <th class="px-4 py-2 text-left">Sl.</th>
                            <th class="px-4 py-2 text-left">Notification No.</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Content</th>
                            <th class="px-4 py-2 text-left">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        <?php $sl = 1; ?>
                        @foreach ($notifications as $notif)
                            <tr class="bg-white">
                                <td class="border px-4 py-2">{{ $sl++ }}</td>
                                <td class="border px-4 py-2"><a href="/notification/{{ $notif->id }}"
                                        class="text-blue-500 hover:underline">{{ $notif->no }}</a></td>
                                <td class="border px-4 py-2">{{ $notif->dt }}</td>
                                <td class="border px-4 py-2">{{ $notif->content }}</td>
                                <td class="border px-4 py-2">
                                    <a href="/notification/{{ $notif->id }}/allotment"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Allotments</a>
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
