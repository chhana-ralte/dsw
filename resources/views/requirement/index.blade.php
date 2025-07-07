<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Kindly select the requirement for next semester
            </x-slot>
        </x-block>
        @if(count($requirements))
            <div style="width:100%; overflow-x:auto">
                Requirements submitted list:
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <td>For session</td>
                        <td>Hostel</td>
                        <td>Room type</td>
                    </tr>
                    <?php $sl=1 ?>
                    @foreach($requirements as $req)
                        <tr>
                            <th>{{ $sl++ }}</th>
                            <td>{{ $req->for_sessn()->name() }}</td>
                            <td>{{ $req->hostel->name }}</td>
                            <td>{{ $req->roomcapacity }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
        @if($allotment->person->requirement(App\Models\Sessn::current()->next()->id))
            Current requirement submitted.
        @else
            <div style="width: 100%; overflow-x:auto">
                Instructions:
                <ul>
                    <li>Click on the requirement to view details.</li>
                    <li>Click on the "Apply" button to submit your application for the selected requirement.</li>
                    <li>Ensure all details are filled out correctly before submitting.</li>
                    <li>For any issues, contact the administration office.</li>
                    <li>Click <a href="/allotment/{{ $allotment->id }}/requirement/create">here</a> to continue</li>
                </ul>
            </div>

        @endif
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
