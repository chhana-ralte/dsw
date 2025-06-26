<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Requirement details {{ $hostel->name }} Hall of Residence
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/requirement">Back to
                        requirement</a>
                </p>

                <p>
                    <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/requirement_list?status=Applied">
                        Applied
                        <span class="badge bg-secondary">{{ App\Models\Requirement::applied($hostel->id)->count() }}</span>
                    </a>
                    <a class="btn btn-primary btn-sm" href="/hostel/{{ $hostel->id }}/requirement_list?status=Resolved">
                        Resolved
                        <span class="badge bg-secondary">{{ App\Models\Requirement::resolved($hostel->id)->count() }}</span>
                    </a>
                </p>

            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form name="frm-submit" method="post" action="/hostel/{{ $hostel->id }}/requirement_list">
                    @csrf
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="action">

                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Student info</th>
                                <th>Current</th>
                                <th>Requirement</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requirements as $req)
                                <tr>

                                    <td>
                                        <input type="checkbox" name="requirement_id[]" value="{{ $req->id }}">
                                    </td>
                                    <td>
                                        @can('view', $req->allot_hostel->allotment)
                                            {{ $req->person->name }}
                                        @else
                                            {{ $req->person->name }}
                                        @endcan
                                    </td>

                                    <td>
                                        @if ($req->person->student())
                                            ({{ $req->person->student()->department }}: {{ $req->person->student()->course }})
                                        @elseif($req->person && $req->person->other())
                                            Not a student ({{ $req->person->other()->remark }})
                                        @else
                                            ( No Info about the person )
                                        @endif
                                    </td>

                                    <td>
                                        Hostel: {{ $req->allot_hostel->hostel->name }}<br>
                                        Type: {{ $req->roomType() }}
                                    </td>
                                    <td>
                                        Hostel: {{ $req->hostel->name }}<br>
                                        Type: {{ $req->roomtype() }}
                                    </td>
                                    @if ($req->new_hostel_id != 0)
                                        <td>
                                            Hostel: {{ $req->new_hostel->name }}<br>
                                            Type: {{ $req->new_roomtype() }}
                                        </td>
                                    @else
                                        <td>
                                            <select name="new_hostel_id[{{ $req->id }}]">
                                                <option value="0">Select Hostel</option>
                                                @foreach(App\Models\Hostel::where('gender', $req->hostel->gender)->get() as $hostel)
                                                    <option value="{{ $hostel->id }}" {{ $req->hostel->name == $hostel->name ? 'selected' : ''}}>{{ $hostel->name }}</option>
                                                @endforeach
                                            </select>
                                            <select name="new_roomcapacity[{{ $req->id }}]">
                                                <option value="0">Select Room Capacity</option>
                                                <option value="1" {{ $req->roomType() == 'Single' ? 'selected' : ''}}>Single</option>
                                                <option value="2" {{ $req->roomType() == 'Double' ? 'selected' : ''}}>Double</option>
                                                <option value="3" {{ $req->roomType() == 'Triple' ? 'selected' : ''}}>Triple</option>
                                                <option value="4" {{ $req->roomType() == 'Dormitory' ? 'selected' : ''}}>Dormitory</option>
                                            </select>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                        <footer>
                            <tr>
                                <td colspan="6">
                                    @if($status == 'Applied')
                                        <button class="btn btn-primary" type="button" value="resolve">Resolve selected students</button>
                                    @elseif($status == 'Resolved')
                                        <button class="btn btn-warning" type="button" value="undo resolve">Undo selected resolved</button>
                                    @endif
                                </td>
                            </tr>
                        </footer>
                    </table>
                    <div id="file-info">
                        <div class="mb-3 form-group">
                            <label class="col-md-5">Enter file number</label>
                            <div class="col md-7">
                                <input type="text" class="form-control" name="file">
                            </div>
                        </div>
                        <div id="file-info" class="mb-3 form-group">
                            <label class="col-md-5">Enter file date</label>
                            <div class="col md-7">
                                <input type="date" class="form-control" name="dt">
                            </div>
                        </div>
                        <div id="file-info" class="mb-3 form-group">
                            <label class="col-md-5">Enter subject</label>
                            <div class="col md-7">
                                <input type="text" class="form-control" name="subject">
                            </div>
                        </div>
                        <div id="file-info" class="mb-3 form-group">
                            <div class="col-md-5"></div>
                            <div class="col md-7">
                                <button class="btn btn-primary" type="button" value="allot">Make allotment</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
               headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               }
            });
            $("div#file-info").hide();
            $("button.btn").click(function(){
                if($(this).val() == "generate"){
                    $("div#file-info").show();
                }
                else if($(this).val() == "allot"){
                    if($("input[name='file']").val() == "" || $("input[name='dt']").val() == "" || $("input[name='subject']").val() == ""){
                        alert("Please enter file number, date and subject.");
                        return false;
                    }
                    if(confirm("Once list is generated, it can not be undone. Are you sure you want to continue?")){
                        $("input[name='action']").val($(this).val());
                        $("form[name='frm-submit']").submit();
                    }
                }
                else{
                    $("input[name='action']").val($(this).val());
                    $("form[name='frm-submit']").submit();
                }
            });
        });
    </script>
</x-layout>
