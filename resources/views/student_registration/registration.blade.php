<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Registration of Student
            </x-slot>

            <form method="post" action="/studentRegistration">
                @csrf
                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <label for="mzuid" class="block text-gray-700 text-sm font-bold text-white">Mzu ID</label>
                    <div class="">
                        @if (isset($student))
                            <input type="text"
                                class="shadow-sm bg-white text-black h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                name="mzuid" value="{{ old('mzuid', $student->mzuid) }}">
                        @else
                            <input type="text"
                                class="shadow-sm bg-white text-black h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                name="mzuid" value="{{ old('mzuid') }}">
                        @endif
                    </div>
                </div>

                <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <label for="rollno" class="block text-gray-700 text-sm font-bold text-white">Roll No.</label>
                    <div class="">
                        @if (isset($student))
                            <input type="text"
                                class="shadow-sm bg-white text-black h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                name="rollno" value="{{ old('rollno', $student->rollno) }}">
                        @else
                            <input type="text"
                                class="shadow-sm bg-white text-black h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                name="rollno" value="{{ old('rollno') }}">
                        @endif
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class=""></div>
                    <div class="">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
                            type="submit">Search</button>
                    </div>
                </div>
            </form>
        </x-block>

        @if (isset($allotment))
            <x-block>
                <x-slot name="heading">
                    Allotment status of {{ $allotment->person->name }}
                </x-slot>
                <table class="w-full">
                    <tr>
                        <td class="px-4 py-2 font-semibold">Allotment Notification and date:</td>
                        <td class="px-4 py-2">{{ $allotment->notification->no }}, dated
                            {{ $allotment->notification->dt }}</td>
                    </tr>
                </table>
            </x-block>
        @endif

    </x-container>
</x-layout>
