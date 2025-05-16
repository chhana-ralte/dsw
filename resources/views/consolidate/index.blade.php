<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
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
                <form method="post" action="/consolidate/" class="pt-4">
                    <input type="hidden" name="type" value="{{ $type }}">
                    @csrf
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Sl</th>
                                <th class="px-4 py-2 text-left">{{ $type }}</th>
                                <th class="px-4 py-2 text-left">Count</th>
                                <th class="px-4 py-2 text-left">Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            @foreach ($lists as $list)
                                <tr class="bg-white hover:bg-gray-100 text-gray-900">
                                    <td class="border px-4 py-2">{{ $sl++ }}</td>
                                    <td class="border px-4 py-2"><a
                                            href="/consolidateDetail?type={{ $type }}&str={{ $list->name }}"
                                            class="text-blue-500 hover:underline">{{ $list->name }}</a></td>
                                    <td class="border px-4 py-2">{{ $list->count }}</td>
                                    <td class="border px-4 py-2"><input type="checkbox" name="list[]"
                                            value="{{ $list->name }}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 flex flex-wrap gap-2 items-center">
                        <label class="w-full md:w-1/3 text-left">Select name for the items selected</label>
                        <div class="w-full md:w-1/3">
                            <input type="text"
                                class="shadow appearance-none border rounded bg-white w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="name" required>
                        </div>
                        <div class="w-full md:w-1/3">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Merge</button>
                        </div>
                    </div>
                </form>
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
