<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                <p>

                </p>

            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form name="frm-submit" method="post" action="/merge">
                    @csrf
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Department</th>
                                <th>Hostel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1 ?>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>
                                        @if($student->person->valid_allotment())
                                            @can('view',$student->person->valid_allotment())
                                                <a href="/allotment/{{ $student->person->valid_allotment()->id }}?back_link=/merge?mzuid={{ $student->mzuid }}">{{ $student->person->name }}</a>
                                            @else
                                                {{ $student->person->name }}
                                            @endcan
                                        @else
                                            {{ $student->person->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $student->course }}
                                    </td>
                                    <td>
                                        {{ $student->department }}
                                    </td>
                                    <td>

                                        @if($student->person->valid_allotment()->valid_allot_hostel())
                                            Hostel: {{ $student->person->valid_allotment()->valid_allot_hostel()->hostel->name }}
                                            @if($student->person->valid_allotment()->valid_allot_hostel()->valid_allot_seat())
                                                <br>Seat: {{ $student->person->valid_allotment()->valid_allot_hostel()->valid_allot_seat()->seat->roomno }}
                                            @else
                                                <br>Seat: No valid seat
                                            @endif
                                        @else
                                            Hostel: No valid allotment
                                            <br>Seat: No valid seat
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </x-block>
    </x-container>
{{-- Modal for duplicate requirement --}}

<div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duplicateModalLabel">Possible duplicates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="duplicate" class="col-form-label">Duplicates from new application</label>
                        <div class="col-md-12" style="width:100%;overfloy-x:auto" id="app">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>MZU ID</th>
                                    <th>Course - Department</th>
                                </tr>
                                <tbody id="app-body">
                                </tbody>
                            </table>
                        </div>
                        {{-- <textarea class="form-control" id="duplicate" name="duplicate"></textarea> --}}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal for duplicate requirement --}}
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
               headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               }
            });


        });
    </script>
</x-layout>
