<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create User
                <p>
                    <a href="/user"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md text-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/user/" class="pt-2">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $id }}">

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="text-gray-700 text-sm font-bold">
                        <label for="name">Name</label>
                    </div>
                    <div class="">
                        <input type="text"
                            class="shadow-sm  h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200 text-gray-700"
                            name="name" value="{{ old('name', isset($person) ? $person->name : '') }}" readonly>
                        @error('name')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if (isset($warden) && $warden)
                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class="text-gray-700 text-sm font-bold">
                            <label for="hostel">Warden of</label>
                        </div>
                        <div class="">
                            <input type="text"
                                class="shadow-sm   h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200 text-gray-700"
                                name="hostel" value="{{ old('hostel', $warden->hostel->name ?? '') }}" readonly>
                            @error('hostel')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                @if (isset($allotment) && $allotment)
                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class="text-gray-700 text-sm font-bold">
                            <label for="allotment">Initial resident of</label>
                        </div>
                        <div class="">
                            <input type="text"
                                class="shadow-sm  h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200 text-gray-700"
                                name="allotment" value="{{ old('allotment', $allotment->hostel->name ?? '') }}"
                                disabled>
                            @error('allotment')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="text-gray-700 text-sm font-bold">
                        <label for="username">Username</label>
                    </div>
                    <div class="">
                        <input type="text"
                            class="shadow-sm bg-white text-black  h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <label for="password" class="text-gray-700 text-sm font-bold">Password</label>
                    <div class="">
                        <input type="password"
                            class="shadow-sm bg-white text-black  h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="password" value="" required>
                        @error('password')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <label for="password_confirmation" class="text-gray-700 text-sm font-bold">Confirm password</label>
                    <div class="">
                        <input type="password"
                            class="shadow-sm bg-white text-black  h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="password_confirmation" value="" required>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="">
                    </div>
                    <div class="flex gap-4">
                        <a href="/user"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Back</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Submit</button>
                    </div>
                </div>
            </form>
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
