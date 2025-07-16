<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New hostel requirement</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        Notification : {{ $notification->no }}, dated {{ $notification->dt }}
        @if(count($allotments) > 0)
            <table class="table">
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Department</th>
                    <th>Hostel</th>
                    <th>Room type</th>
                    <th>Email</th>
                    <th>Mobile</th>
                </tr>
                <?php $sl = 1 ?>
                @foreach($allotments as $allot)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $allot->person->name }}</td>
                        <td>{{ $allot->person->student()->course }}</td>
                        <td>{{ $allot->person->student()->department }}</td>
                        <td>{{ $allot->requirement->new_hostel->name }}</td>
                        <td>{{ $allot->requirement->new_roomtype() }}</td>
                        <td>{{ $allot->person->email }}</td>
                        <td>{{ $allot->person->mobile }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if(count($sem_allots) > 0)
            <table class="table">
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Department</th>
                    <th>Hostel</th>
                    <th>Room type</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>MZU ID</th>
                </tr>
                <?php $sl = 1 ?>
                @foreach($sem_allots as $allot)
                    <tr>
                        <td>{{ $allot->sl }}</td>
                        <td>{{ $allot->allotment->person->name }}</td>
                        <td>{{ $allot->allotment->person->student()->course }}</td>
                        <td>{{ $allot->allotment->person->student()->department }}</td>
                        <td>{{ $allot->requirement->new_hostel->name }}</td>
                        <td>{{ $allot->requirement->new_roomtype() }}</td>
                        <td>{{ $allot->allotment->person->email }}</td>
                        <td>{{ $allot->allotment->person->mobile }}</td>
                        <td>{{ $allot->allotment->person->student()->mzuid }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        <script>
        // Function to update certificate data

        </script>
    </body>
</html>
