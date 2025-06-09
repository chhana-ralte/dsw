<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Allotments under Notification {{ $notification->no }} dated {{ $notification->dt }}
                <p>
                    <a class="btn btn-primary btn-sm" href="/notification/{{ $notification->id }}/allotment/create">Create
                        new</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</td>
                            <th>Allotted Hostel</td>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = ($allotments->currentPage() - 1) * $allotments->perPage() + 1; ?>
                        @foreach ($allotments as $allot)
                            <tr class="table-white">
                                <td>{{ $sl++ }}</td>
                                <td><a href="/allotment/{{ $allot->id }}">{{ $allot->person->name }}</td>
                                @if ($allot->person->student())
                                    <td>{{ $allot->person->student()->course }}</td>
                                    <td>{{ $allot->person->student()->department }}</td>
                                @elseif($allot->person->other())
                                    <td colspan="2">{{ $allot->person->other()->remark }}</td>
                                @else
                                    <td colspan="2">Unknown</td>
                                @endif
                                <td>{{ $allot->hostel->name }}</td>
                                <td>
                                    Admission: {{ $allot->admitted ? 'Yes' : 'No' }},
                                    Valid: {{ $allot->valid ? 'Yes' : 'No' }},
                                    Left: {{ $allot->finished ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfooter>
                        <tr>
                            <td colspan="6">
                                <div class="float-end">
                                    {{ $allotments->links() }}
                                </div>
                            </td>
                        </tr>
                </table>
            </div>
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
