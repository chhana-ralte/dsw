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
                    <a class="btn btn-primary btn-sm" href="/requirement/summary">
                        Summary
                    </a>
                    <a class="btn {{ $status=='Nothing'?'btn-outline-primary':'btn-primary' }} btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Nothing">
                        Not applied
                        <span class="badge bg-secondary">{{ App\Models\Requirement::nothing($hostel?$hostel->id:0)->count() }}</span>
                    </a>
                    <a class="btn {{ $status=='Applied'?'btn-outline-primary':'btn-primary' }} btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Applied">
                        Applied
                        <span class="badge bg-secondary">{{ App\Models\Requirement::applied($hostel?$hostel->id:0)->count() }}</span>
                    </a>
                    <a class="btn {{ $status=='Resolved'?'btn-outline-primary':'btn-primary' }} btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Resolved">
                        Resolved
                        <span class="badge bg-secondary">{{ App\Models\Requirement::resolved($hostel?$hostel->id:0)->count() }}</span>
                    </a>
                    <a class="btn {{ $status=='Notified'?'btn-outline-primary':'btn-primary' }} btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Notified">
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
                            <?php
                                if($hostel){
                                    $sl = 1;
                                }
                                else{
                                    $sl = ($requirements->currentPage() - 1) * $requirements->perPage() + 1;
                                }
                            ?>
                            @foreach ($requirements as $req)
                                <tr>

                                    <td>
                                        <input type="checkbox" name="requirement_id[]" value="{{ $req->id }}">
                                    </td>
                                    <td>
                                        @if($status == 'Notified')
                                            {{ $req->sem_allot()->sl }}
                                        @else
                                            {{ $sl++ }}
                                        @endif
                                    </td>
                                    <td>
                                        @can('view', $req->allot_hostel->allotment)
                                            <a href="/allotment/{{ $req->allot_hostel->allotment->id }}">{{ $req->person->name }}</a>
                                        @else
                                            {{ $req->person->name }}
                                        @endcan
                                        @if(count($req->duplicates()) > 0)
                                            <br><button type="button" class="btn badge bg-warning btn-duplicate" value="{{ $req->id}}">Possible duplicate</button>
                                        @endif
                                        @if($req->person->mobile == '' || $req->person->email == '')
                                            <br><span class="badge bg-danger">No mobile or email</span>
                                        @endif
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
                                        @if($req->allot_hostel->valid_allot_seat())
                                            Type: {{ $req->allot_hostel->valid_allot_seat()->seat->room->type }}
                                        @else
                                            Type: Unknown
                                        @endif
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
                                                @foreach(App\Models\Hostel::where('gender', $req->hostel->gender)->get() as $h)
                                                    <option value="{{ $h->id }}" {{ $req->hostel->name == $h->name ? 'selected' : ''}}>{{ $h->name }}</option>
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

                        <footer>
                            <tr>
                                <td colspan="6">
                                    @if($status == 'Applied')
                                        @if(auth()->user()->can('resolves', App\Models\Requirement::class) || auth()->user()->isWardenOf($hostel?$hostel->id:0))
                                            <button class="btn btn-primary btn-action" type="button" value="confirm resolve">Resolve selected students</button>
                                        @endif
                                    @elseif($status == 'Resolved')
                                        @if(auth()->user()->can('resolves', App\Models\Requirement::class) || auth()->user()->isWardenOf($hostel?$hostel->id:0))
                                            <button class="btn btn-warning btn-action" type="button" value="undo resolve">Undo selected resolved</button>
                                        @endif
                                        @can('notifies', App\Models\Requirement::class)
                                            <button class="btn btn-primary btn-action" type="button" value="confirm notify">Notify</button>
                                        @endcan
                                    @elseif($status == 'Notified')
                                        @can('notifies', App\Models\Requirement::class)
                                            <button class="btn btn-warning btn-action" type="button" value="undo notify">Undo selected notified</button>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        </footer>
                    </table>

                    @if(!$hostel)
                        <div class="float-end">
                            {{ $requirements->links() }}
                        </div>
                    @endif
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
                        <div class="col-md-12" style="width:100%;overflow-x:auto" id="app">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Appl. ID</th>
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

            $("div#file-info").hide();

            $('.table tr').click(function(event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });

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

            $("button.btn-duplicate").click(function(){
                $.ajax({
                    type: "get",
                    url: "/requirement/" + $(this).val() + "/duplicate",
                    success: function(data, status) {
                        $("#app-body").empty();
                        for (var i = 0; i < data.length; i++) {
                            var str = "<tr>";
                            str += "<td>" + data[i].id + "</td>";
                            str += "<td>" + data[i].name + "</td>";
                            str += "<td>" + data[i].mobile + "</td>";
                            str += "<td>" + data[i].mzuid + "</td>";
                            str += "<td>" + data[i].course + " - " + data[i].department + "</td>";
                            str += "</tr>";
                            $("#app-body").append(str);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error getting duplicate: " + xhr.responseText);
                    }
                });
                $("#duplicateModal").modal('show');
            });
        });
    </script>
</x-layout>
