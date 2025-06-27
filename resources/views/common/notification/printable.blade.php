<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hostel No Dues Certificate - Print Preview</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        Notification : {{ $notification->no }}, dated {{ $notification->dt }}
        @if(count($allotments) > 0)
            <table class="table">
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Course & Department</th>
                    <th>Hostel & room type</th>
                </tr>
                <?php $sl = 1 ?>
                @foreach($allotments as $allot)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $allot->person->name }}</td>
                        <td>{{ $allot->person->student()->course }}<br>{{ $allot->person->student()->department }}</td>
                        <td>{{ $allot->requirement->new_hostel->name }}<br>{{ $allot->requirement->new_roomtype() }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if(count($sem_allots) > 0)
            <table class="table">
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Course & Department</th>
                    <th>Hostel & room type</th>
                </tr>
                <?php $sl = 1 ?>
                @foreach($sem_allots as $allot)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $allot->allotment->person->name }}</td>
                        <td>{{ $allot->allotment->person->student()->course }}<br>{{ $allot->allotment->person->student()->department }}</td>
                        <td>{{ $allot->requirement->new_hostel->name }}<br>{{ $allot->requirement->new_roomtype() }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        <script>
        // Function to update certificate data

        </script>
    </body>
</html>
