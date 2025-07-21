<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Hostel-wise allotment of newly admitted students
                <p>
                    <a href="/application/" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Hostel</th>
                            <th>Single</th>
                            <th>Double</th>
                            <th>Triple</th>
                            <th>Dorm</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1 ?>
                        @foreach($hostel_wise as $data)
                            <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $data->hostel }}</td>
                            <td>{{ $data->single }}</td>
                            <td>{{ $data->double }}</td>
                            <td>{{ $data->triple }}</td>
                            <td>{{ $data->dorm }}</td>
                            <td>{{ $data->total }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>

            </div>
        </x-block>

        <x-block>
            <x-slot name="heading">
                Hostel-wise allotment of newly admitted students
                <p>
                    <a href="/application/" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Department</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1 ?>
                        @foreach($dept_wise as $data)
                            <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $data->department }}</td>
                            <td>{{ $data->cnt }}</td>
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

    </script>
</x-layout>
