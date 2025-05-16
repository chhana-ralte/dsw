<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                <x-button type="a" href="/consolidate?type={{ $type }}">Back</x-button>
                Consolidation
                <p class="mt-2">
                <div class="bg-blue-500 rounded-md shadow-sm inline-flex">
                    <a class="px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        href="/consolidate?type=Course">Course</a>
                    <a class="px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        href="/consolidate?type=Department">Department</a>
                    <a class="px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-r-md"
                        href="/consolidate?type=Category">Category</a>
                </div>
                </p>
            </x-slot>
            @if (isset($lists))
                @if ($type == 'Course' || $type == 'Department')
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Sl</th>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Department</th>
                                <th class="px-4 py-2 text-left">Course</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            <?php $sl = 1; ?>
                            @foreach ($lists as $list)
                                <tr class="bg-white hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $sl++ }}</td>
                                    <td class="border px-4 py-2">{{ $list->name }}</td>
                                    <td class="border px-4 py-2">{{ $list->department }}</td>
                                    <td class="border px-4 py-2">{{ $list->course }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($type == 'Category')
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Sl</th>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Category</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            <?php $sl = 1; ?>
                            @foreach ($lists as $list)
                                <tr class="bg-white hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $sl++ }}</td>
                                    <td class="border px-4 py-2">{{ $list->name }}</td>
                                    <td class="border px-4 py-2">{{ $list->category }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </x-block>

    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("button.btn-delete").click(function() {
                if (confirm('Are you sure you want to delete?')) {

                }
            });
        })
    </script>
</x-layout>
