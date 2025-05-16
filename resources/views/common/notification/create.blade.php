<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Notification
                <p>
                    <a href="/notification/"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/notification">
                @csrf
                <div>
                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class=" text-sm font-bold text-white">
                            Notification No.
                        </div>
                        <div class="">
                            <input type="text" name="no" value="{{ old('no') }}"
                                class="shadow-sm bg-white text-black h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>
                    </div>

                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class=" text-sm font-bold text-white">
                            Date
                        </div>
                        <div class="">
                            <input type="date" name="dt"
                                class="shadow-sm bg-white text-black h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('dt') }}" required>
                        </div>
                    </div>

                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class=" text-sm font-bold text-white">
                            Content
                        </div>
                        <div class="">
                            <textarea name="content"
                                class="shadow-sm bg-white text-black  px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="">
                        </div>
                        <div class="">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </x-block>

    </x-container>
    <script>
        $(document).ready(function() {
            $("input[name='start_yr']").keyup(function() {
                if ($(this).val().length >= 4) {
                    vl = parseInt($(this).val()) + 1;
                    $("input[name='end_yr']").val(vl);
                }
            });
        });
    </script>
</x-layout>
