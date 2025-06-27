<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Continuing allotments under Notification {{ $notification->no }} dated {{ $notification->dt }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/notification/{{ $notification->id }}">Back</a>
                    <button class="btn btn-secondary btn-sm" id="printable" value="{{ $notification->id }}">Printable</button>
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
                            <th>Allotted hostel</td>
                            <th>Room type</td>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1 ?>
                        @foreach ($sem_allots as $allot)
                            <tr class="table-white">
                                <td>{{ $sl++ }}</td>
                                <td><a href="/sem_allot/{{ $allot->id }}">{{ $allot->allotment->person->name }}</td>
                                @if ($allot->allotment->person->student())
                                    <td>{{ $allot->allotment->person->student()->course }}</td>
                                    <td>{{ $allot->allotment->person->student()->department }}</td>
                                @elseif($allot->allotment->person->other())
                                    <td colspan="2">{{ $allot->allotment->person->other()->remark }}</td>
                                @else
                                    <td colspan="2">Unknown</td>
                                @endif
                                <td>{{ $allot->requirement->new_hostel->name }}</td>
                                <td>{{ $allot->requirement->new_roomtype() }}</td>
                                <td>

                                    Valid: {{ $allot->valid ? 'Yes' : 'No' }},

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

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
        $("button#printable").click(function(){
            window.open("/notification/" + $(this).val() + "/printable");
        });
    </script>
</x-layout>
