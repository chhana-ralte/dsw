<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Change password for: {{ auth()->user()->name }}
            </x-slot>
            <form method="post" action="/user/changePassword" class="pt-2">
                @csrf

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="text-white text-sm font-bold">
                        <label for="name">Name</label>
                    </div>
                    <div class="">
                        <input type="text"
                            class="shadow-sm h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200 text-black"
                            name="name" value="{{ $user->name }}" disabled>
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="text-white text-sm font-bold">
                        <label for="username">Username</label>
                    </div>
                    <div class="">
                        <input type="text"
                            class="shadow-sm h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200 text-black"
                            name="username" value="{{ $user->username }}" disabled>
                    </div>
                </div>
                {{--
                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" disabled>
                    </div>
                </div>
                --}}

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="text-white text-sm font-bold">
                        New Password
                    </div>
                    <div class="">
                        <input type="password"
                            class="shadow-sm bg-white text-black h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="password" required>
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="text-white text-sm font-bold">
                        Confirm Password
                    </div>
                    <div class="">
                        <input type="password"
                            class="shadow-sm bg-white text-black h-10 px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            name="confirm_password" required>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="">
                    </div>
                    <div class="flex gap-4">
                        <a href="/"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md">Home</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Change
                            password</button>
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
        });
    </script>
</x-layout>
