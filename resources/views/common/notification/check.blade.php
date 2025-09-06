<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Notification search
            </x-slot>

            <form name="frm_check" method="post" action="/notification/check">
                @csrf
                <input type="hidden" name="type" value="str">

                <div class="mb-3 form-group row">
                    <label for="dob" class="col col-md-4">Enter reference no.</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="str" value="{{ old('str',$str) }}" required>
                    </div>
                </div>
                <div class="mb-3 form-group row">
                    <div class="col col-md-4"></div>
                    <div class="col col-md-4">
                        <button type="submit" class="btn btn-primary submit">Check</button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
    @if(isset($sem_allot))
        <x-container>
            <x-block>
                <x-slot name="heading">
                    Notification reference details : Semester allotment
                </x-slot>
                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto">
                        <tr>
                            <td>Notification no.</td>
                            <td>{{ $sem_allot->notification->no }}</td>
                        </tr>
                        <tr>
                            <td>Allotment subject</td>
                            <td>{{ $sem_allot->notification->content }}</td>
                        </tr>
                        <tr>
                            <td>Allotment date</td>
                            <td>{{ $sem_allot->notification->dt }}</td>
                        </tr>
                        <tr>
                            <td>Allotment type</td>
                            <td>{{ $sem_allot->notification->type }}</td>
                        </tr>
                        <tr>
                            <td>Name of Student</td>
                            <td><a href="/allotment/{{ $sem_allot->allotment->id }}">{{ $sem_allot->allotment->person->name }}</a></td>
                        </tr>
                        <tr>
                            <td>Student's course</td>
                            <td>{{ $sem_allot->allotment->person->student()->course }}</td>
                        </tr>
                        <tr>
                            <td>Student's department</td>
                            <td>{{ $sem_allot->allotment->person->student()->department }}</td>
                        </tr>
                        <tr>
                            <td>Hostel</td>
                            <td>{{ $sem_allot->requirement->new_hostel->name }}</td>
                        </tr>
                        <tr>
                            <td>Room type</td>
                            <td>{{ $sem_allot->requirement->new_roomtype() }}</td>
                        </tr>
                        <tr>
                            <td>Payment status</td>
                            <td>To be updated.</td>
                        </tr>
                    </table>
                </div>

            </x-block>
        </x-container>
    @elseif(isset($allotment))
        <x-container>
            <x-block>
                <x-slot name="heading">
                    Notification reference details: New allotment
                </x-slot>
                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto">
                        <tr>
                            <td>Notification no.</td>
                            <td>{{ $allotment->notification->no }}</td>
                        </tr>
                        <tr>
                            <td>Allotment subject</td>
                            <td>{{ $allotment->notification->content }}</td>
                        </tr>
                        <tr>
                            <td>Allotment date</td>
                            <td>{{ $allotment->notification->dt }}</td>
                        </tr>
                        <tr>
                            <td>Allotment type</td>
                            <td>{{ $allotment->notification->type }}</td>
                        </tr>
                        <tr>
                            <td>Name of Student</td>
                            <td><a href="/allotment/{{ $allotment->id }}">{{ $allotment->person->name }}</a></td>
                        </tr>
                        <tr>
                            <td>Student's course</td>
                            <td>{{ $allotment->person->student()->course }}</td>
                        </tr>
                        <tr>
                            <td>Student's department</td>
                            <td>{{ $allotment->person->student()->department }}</td>
                        </tr>
                        <tr>
                            <td>Hostel</td>
                            <td>{{ $allotment->hostel->name }}</td>
                        </tr>
                        <tr>
                            <td>Room type</td>
                            <td>{{ App\Models\Room::room_type($allotment->roomtype) }}</td>
                        </tr>
                        <tr>
                            <td>Payment status</td>
                            <td>To be updated.</td>
                        </tr>
                    </table>
                </div>

            </x-block>
        </x-container>
    @elseif($str != '')
        <span class="text-danger">No application found.</span>
    @endif



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
