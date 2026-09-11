<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New hostel requirement</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        Notification : {{ $noti_master->no }}, dated {{ $noti_master->dt }}
        @if(count($allotments) > 0)
            <table class="table">
                <tr>
                    <th>Hostel</th>
                    <th>Ref.</th>
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
                @foreach($allotments as $allot)
                    <tr>
                        <td>{{ $allot->hostel->name }}</td>
                        <td>{{ $allot->notification->id }}/{{ $allot->rand }}/{{ $allot->sl }}</td>
                        <td>{{ $allot->person->name }}</td>
                        <td>{{ $allot->person->student()->course }}</td>
                        <td>{{ $allot->person->student()->department }}</td>
                        <td>{{ $allot->hostel->name }}</td>
                        <td>{{ App\Models\Room::room_type($allot->roomtype) }}</td>
                        <td>{{ $allot->person->email }}</td>
                        <td>{{ $allot->person->mobile }}</td>
                        <td>{{ $allot->person->student()->mzuid }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        

        <script>
        // Function to update certificate data

        </script>
    </body>
</html>
