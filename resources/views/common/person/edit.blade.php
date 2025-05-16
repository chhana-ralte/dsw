<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Editing personal info: {{ $person->name }}
                <p>
                    <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded-md text-xs"
                        href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Editing personal details
            </x-slot>
            <form method="post" action="/person/{{ $person->id }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type='hidden' name='back_link' value="{{ $back_link }}">
                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="name" class="block text-black text-sm font-bold md:col-span-3">Name</label>
                    <div class="md:col-span-4">
                        <input type="text"
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="name" value="{{ old('name', $person->name) }}">
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="father"
                        class="block text-black text-sm font-bold md:col-span-3">Father/Guardian</label>
                    <div class="md:col-span-4">
                        <input type="text"
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="father" value="{{ old('father', $person->father) }}">
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="mobile" class="block text-black text-sm font-bold md:col-span-3">Mobile</label>
                    <div class="md:col-span-4">
                        <input type="text"
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="mobile" value="{{ old('mobile', $person->mobile) }}">
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="email" class="block text-black text-sm font-bold md:col-span-3">Email</label>
                    <div class="md:col-span-4">
                        <input type="email"
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="email" value="{{ old('email', $person->email) }}">
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="category" class="block text-black text-sm font-bold md:col-span-3">Category</label>
                    <div class="md:col-span-4">
                        <select name='category'
                            class='bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md'>
                            <option>Select Category</option>
                            <option value='General' {{ $person->category == 'General' ? ' selected ' : '' }}>General
                            </option>
                            <option value='OBC' {{ $person->category == 'OBC' ? ' selected ' : '' }}>OBC</option>
                            <option value='SC' {{ $person->category == 'SC' ? ' selected ' : '' }}>SC</option>
                            <option value='ST' {{ $person->category == 'ST' ? ' selected ' : '' }}>ST</option>
                            <option value='EWS' {{ $person->category == 'EWS' ? ' selected ' : '' }}>EWS</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="state" class="block text-black text-sm font-bold md:col-span-3">State</label>
                    <div class="md:col-span-4">
                        <input type="text"
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="state" value="{{ old('state', $person->state) }}">
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-start">
                    <label for="address" class="block text-black text-sm font-bold md:col-span-3">Address</label>
                    <div class="md:col-span-4">
                        <textarea
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="address">{{ old('address', $person->address) }}</textarea>
                    </div>
                </div>
                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <label for="photo" class="block text-black text-sm font-bold md:col-span-3">Photo</label>
                    <div class="md:col-span-4">
                        <input type="file"
                            class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="photo">
                    </div>
                </div>
                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <div class="md:col-span-3"></div>
                    <div class="md:col-span-4">
                        <img width="200px" src="{{ $person->photo }}" alt="" srcset="">
                    </div>
                </div>
                <div class="mb-3 grid grid-cols-1 md:grid-cols-7 gap-4">
                    <div class="md:col-span-3"></div>
                    <div class="md:col-span-4">
                        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md"
                            href="{{ $back_link }}">Cancel</a>
                        <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md"
                            type="submit" id="update">Update</button>
                    </div>
                </div>
            </form>
        </x-block>

    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button#unavailable").click(function() {
                $("form#unavailabl").submit();
            });

            $("a.deallocate").click(function() {
                if (confirm("Are you sure you want to deallocate this student from the existing seat?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/seat/" + $(this).attr("id") + "/deallocate",

                        success: function(data, status) {
                            if (data == "Success") {
                                alert("Deallocation successful");
                                location.replace("/person/{{ $person->id }}");
                            }
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                }
                //alert($(this).attr('id'));
            });
        });
    </script>
</x-layout>
