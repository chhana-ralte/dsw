<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Check your admission status
            </x-slot>
            <form method="post" action="/admissioncheck">
                @csrf
                <div class="mb-3 flex items-center">
                    <label for="mzuid" class="w-1/3">Mzu ID</label>
                    <div class="w-2/3">
                        @if (isset($student))
                            <input type="text"
                                class="shadow appearance-none border rounded w-full bg-white py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="mzuid" value="{{ old('mzuid', $student->mzuid) }}">
                        @else
                            <input type="text"
                                class="shadow appearance-none border rounded w-full bg-white py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="mzuid" value="{{ old('mzuid') }}">
                        @endif
                    </div>
                </div>

                <div class="mb-3 flex items-center">
                    <label for="rollno" class="w-1/3">Roll No.</label>
                    <div class="w-2/3">
                        @if (isset($student))
                            <input type="text"
                                class="shadow appearance-none border rounded w-full bg-white py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="rollno" value="{{ old('rollno', $student->rollno) }}">
                        @else
                            <input type="text"
                                class="shadow appearance-none border rounded w-full bg-white py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="rollno" value="{{ old('rollno') }}">
                        @endif
                    </div>
                </div>

                <div class="mb-3 flex items-center">
                    <div class="w-1/3"></div>
                    <div class="w-2/3">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">Search</button>
                    </div>
                </div>
            </form>
        </x-block>
        @if (isset($allotment))
            <x-block>
                <x-slot name="heading">
                    Admission status of {{ $allotment->person->name }}
                </x-slot>
                @if (count($allotment->admissions) > 0)
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-black">Session</th>
                                <th class="px-4 py-2 text-left text-black">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allotment->admissions as $admission)
                                <tr class="bg-white hover:bg-gray-100 text-gray-900">
                                    <td class="border px-4 py-2">{{ $admission->sessn->name() }}</td>
                                    <td class="border px-4 py-2">Done</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h4 class="text-lg font-semibold">No hostel admission record available</h4>
                @endif
            </x-block>
        @endif
    </x-container>
</x-layout>
