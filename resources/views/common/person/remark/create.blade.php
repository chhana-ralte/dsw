<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Remark(s) about {{ $person->name }}
                <p>
                    <a href="/person/{{ $person->id }}/person_remark/"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/person/{{ $person->id }}/person_remark">
                @csrf
                <div>
                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class="text-white text-sm font-bold">
                            Reporting date
                        </div>
                        <div class="">
                            <input type="date" name="remark_dt" value="{{ old('remark_dt') }}"
                                class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full h-10 px-3 sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>
                    </div>

                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class="text-white text-sm font-bold">
                            Remark (Only subject, detail can be entered later)
                        </div>
                        <div class="">
                            <input type="text" name="remark"
                                class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full h-10 px-3 sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('remark') }}" required>
                        </div>
                    </div>

                    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div class="text-white text-sm font-bold">
                            Score (worst = -5, best=5, neutral=0)
                        </div>
                        <div class="">
                            <select name="score"
                                class="bg-white text-black shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full h-10 px-3 sm:text-sm border-gray-300 rounded-md">
                                @for ($i = -5; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $i == 0 ? ' selected ' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Create</button>
                        </div>
                    </div>
                </div>
            </form>



        </x-block>

    </x-container>
</x-layout>
