<x-layout>
    <x-slot:heading>
        Login page
    </x-slot:heading>

    <form method='post' action='/login'>
        @csrf
        <x-container>
            <x-block>
                <div align="center" style="width: 100%; overflow-x:auto">
                    <div class="rounded-xl shadow-md" style="width: 350px" centered>
                        <div class="bg-white py-5 px-4 font-semibold text-black">
                            Login form
                        </div>
                        <div class="bg-white">
                            <div class="row mb-4 pt-2">
                                <div class="w-full col-4  md:w-1/3 px-3 mb-6 md:mb-0">
                                    <Label class="block text-black text-sm font-bold mb-2">Username</label>
                                </div>
                                <div class="w-full col-8 md:w-2/3 px-3">
                                    <input
                                        class=" appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="row mb-4 pb-4">
                                <div class="w-full col-4 md:w-1/3 mb-6 md:mb-0">
                                    <Label class="block text-black text-sm font-bold mb-2">Password</label>
                                </div>
                                <div class="w-full col-8 md:w-2/3 px-3">
                                    <input
                                        class=" appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                                        type="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 py-3 px-4">
                            <div class="flex flex-wrap">
                                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                    <x-button type="submit">Login</x-button>
                                </div>
                            </div>

                        </div>
                    </div>
            </x-block>
        </x-container>
    </form>

</x-layout>
