<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                @if($hostel)
                    Requirement details {{ $hostel->name }} Hall of Residence
                @else
                    Requirement details
                @endif
                <p>
                <div class="form-group row">
                    <label for="hostel" class="col-md-4">Select hostel:</label>
                    <div class="col-md-8">
                        <select class="form-control" name="hostel">
                            <option value="0">All</option>
                            @foreach($hostels as $h)
                                <option value="{{ $h->id }}" {{ $h->id == ($hostel?$hostel->id:0)?' selected ':'' }}>{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </p>

                <p>
                    <a class="btn btn-primary btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Applied">
                        Applied
                        <span class="badge bg-secondary">{{ App\Models\Requirement::applied($hostel?$hostel->id:0)->count() }}</span>
                    </a>
                    <a class="btn btn-primary btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Resolved">
                        Resolved
                        <span class="badge bg-secondary">{{ App\Models\Requirement::resolved($hostel?$hostel->id:0)->count() }}</span>
                    </a>
                    <a class="btn btn-primary btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Notified">
                        Notified
                        <span class="badge bg-secondary">{{ App\Models\Requirement::notified($hostel?$hostel->id:0)->count() }}</span>
                    </a>
                </p>

            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form name="frm-submit" method="post" action="/requirement/list">
                    @csrf
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="action">
                    <input type="hidden" name="hostel_id" value="{{ $hostel?$hostel->id:0 }}">
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="all"></th>
                                <th>Sl</th>

                                <th>Name</th>
                                <th>Student info</th>
                                <th>Current</th>
                                <th>Requirement</th>
                                <th>To Update</th>
                                @if($status == 'Notified')
                                    <th>Notification</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = ($requirements->currentPage() - 1) * $requirements->perPage() + 1; ?>
                            @foreach ($requirements as $req)
                                <tr>

                                    <td>
                                        <input type="checkbox" name="requirement_id[]" value="{{ $req->id }}">
                                    </td>
                                    <td>{{ $sl++ }}</td>
                                    <td>
                                        @can('view', $req->allot_hostel->allotment)
                                            <a href="/allotment/{{ $req->allot_hostel->allotment->id }}">{{ $req->person->name }}</a>
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
                                    @if($status == 'Notified')
                                        <td>
                                            <a href="/notification/{{ $req->sem_allot()->notification->id }}">
                                                {{ $req->sem_allot()->notification->no }}<br>
                                                {{ $req->sem_allot()->notification->dt }}
                                            </a>

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        @can('manages',App\Models\Requirement::class)
                            <footer>
                                <tr>
                                    <td colspan="6">
                                        @if($status == 'Applied')
                                            <button class="btn btn-primary btn-action" type="button" value="resolve">Resolve selected students</button>
                                        @elseif($status == 'Resolved')
                                            <button class="btn btn-warning btn-action" type="button" value="undo resolve">Undo selected resolved</button>
                                            <button class="btn btn-primary btn-action" type="button" value="notify">Notify</button>
                                        @elseif($status == 'Notified')
                                            <button class="btn btn-warning btn-action" type="button" value="undo notify">Undo selected notified</button>
                                        @endif
                                    </td>
                                </tr>
                            </footer>
                        @endcan
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
                                <button class="btn btn-primary btn-action" type="button" value="allot">Make allotment</button>
                            </div>
                        </div>
                    </div>
                    <div class="float-end">
                        {{ $requirements->links() }}
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

            $("button.btn-action").click(function(){
                var nos=0;
                $("input[name='requirement_id[]']").each(function(){
                    if($(this).prop('checked')){
                        nos++;
                    }
                });

                if(nos == 0){
                    alert("Please select the students.");
                    return false;
                }
                if($(this).val() == "notify"){
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

            $("input#all").click(function(){
                $("input[name='requirement_id[]']").each(function(){
                    $(this).prop('checked',$("input#all").prop("checked"));
                });
            });

            $("select[name='hostel']").change(function(){
                location.replace('/requirement/list?hostel_id=' + $(this).val() + '&status=' + $("input[name='status']").val());
                exit();
            });
        });
    </script>
</x-layout>
