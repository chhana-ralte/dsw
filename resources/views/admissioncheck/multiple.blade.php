<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Matched data
            </x-slot>

            The following match has been found
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>Course</td>
                    <td>department</td>
                    <td>Mzu ID</td>
                    <td>Roll No.</td>
                </tr>
                @foreach($allotments as $allotment)
                    <tr>
                    <td><a href="/admissioncheck?allotment={{ $allotment->id }}&rand={{ uniqid() }}">{{ $allotment->person->name }}</a></td>
                    <td>{{ $allotment->person->student()->course }}</td>
                    <td>{{ $allotment->person->student()->department }}</td>
                    <td>{{ $allotment->person->student()->mzuid }}</td>
                    <td>{{ $allotment->person->student()->rollno }}</td>
                    </tr>
                @endforeach
            </table>
        </x-block>
    </x-container>
</x-layout>
