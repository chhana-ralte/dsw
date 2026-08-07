<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Matched data
            </x-slot>

            <p>
                <a class="btn btn-secondary btn-sm" href="/studentRegistration">Back</a>
            </p>
            The following match(es) has been found
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>Course</td>
                    <td>department</td>
                    <td>Mzu ID</td>
                    <td>Roll No.</td>
                    <td>Action</td>
                </tr>
                @foreach($allotments as $allotment)
                    <tr>
                    <td>{{ $allotment->person->name }}</td>
                    <td>{{ $allotment->person->student()->course }}</td>
                    <td>{{ $allotment->person->student()->department }}</td>
                    <td>{{ $allotment->person->student()->mzuid }}</td>
                    <td>{{ $allotment->person->student()->rollno }}</td>

                    <td>
                        @if($allotment->confirmed && $allotment->valid)
                            <a class="btn btn-sm btn-primary" href="/studentRegistration?allotment={{ $allotment->id }}&rand={{ uniqid() }}">Select</a>
                        @else
                            <span class="text-warning">Invalid</span>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </table>
            <span class="text-danger">
                If you are not available in this list, contact your warden and update your MZU ID or your roll number
            </span>
        </x-block>
    </x-container>
</x-layout>
