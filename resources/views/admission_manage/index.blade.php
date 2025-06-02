<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of applicants for Hostel Admission.
            </x-slot>
            <div>
                <p>Welcome to the application form. Please fill out the necessary details below.</p>
                <p>Click <a href="{{ route('application.create') }}">Here</a> to Go to Application
                    Form</p>
            </div>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>MZU ID</th>
                            @auth
                                @can('update', auth()->user())
                                    <th>Action</th>
                                @endcan
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($applications) > 0)
                            @foreach ($applications as $application)
                                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                                    <td>
                                        @can('view', $application)
                                            <a
                                                href="/admission_manage/{{ $application->id }}">{{ $application->person->name }}</a>
                                        @else
                                            {{ $application->person->name }}
                                        @endcan
                                    </td>
                                    @if ($application->person->student())
                                        <td>{{ $application->person->student()->course }}</td>
                                        <td>{{ $application->person->student()->department }}</td>
                                        <td>{{ $application->person->student()->mzuid }}</td>
                                    @elseif($application->person->other())
                                        <td colspan=3>Not a student ({{ $application->person->other()->remark }})</td>
                                    @endif
                                    @auth
                                        @if (auth()->user()->isWardenOf($application->hostel_id))
                                            <td><a class="btn btn-primary"
                                                    href="/admission_manage/{{ $application->id }}/approve">Approve</a></td>
                                        @endif
                                    @endauth
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No applications found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });


        });
    </script>
</x-layout>
