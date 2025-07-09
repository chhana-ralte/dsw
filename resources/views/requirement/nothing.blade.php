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
                    <a class="btn btn-outline-primary btn-sm" href="/requirement/list?{{ $hostel?'hostel_id='. $hostel->id .'&':''}}status=Nothing">
                        Not applied
                        <span class="badge bg-secondary">{{ App\Models\Requirement::nothing($hostel?$hostel->id:0)->count() }}</span>
                    </a>
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

                            @foreach ($requirements as $allot_hostel)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="allot_hostel_ids[]" value="{{ $allot_hostel->id }}">
                                    </td>
                                    <td>{{ $sl++ }}</td>
                                    <td>
                                        @can('view', $allot_hostel->allotment)
                                            <a href="/allotment/{{ $allot_hostel->allotment->id }}">{{ $allot_hostel->allotment->person->name }}</a>
                                        @else
                                            {{ $allot_hostel->allotment->person->name }}
                                        @endcan
                                    </td>

                                    <td>
                                        @if ($allot_hostel->allotment->person->student())
                                            ({{ $allot_hostel->allotment->person->student()->department }}: {{ $allot_hostel->allotment->person->student()->course }})
                                        @elseif($allot_hostel->allotment->person && $allot_hostel->allotment->person->other())
                                            Not a student ({{ $allot_hostel->allotment->person->other()->remark }})
                                        @else
                                            ( No Info about the person )
                                        @endif
                                    </td>

                                    <td>
                                        Hostel: {{ $allot_hostel->hostel->name }}<br>
                                        @if($allot_hostel->valid_allot_seat())
                                            Type: {{ $allot_hostel->valid_allot_seat()->seat->room->type }}
                                        @else
                                            Type: Unknown
                                        @endif
                                    </td>

                                    <td>
                                        No request received
                                    </td>
                                    <td>
                                        <select name="new_hostel_id[{{ $allot_hostel->hostel->id }}]">
                                            <option value="0">Select Hostel</option>
                                            @foreach(App\Models\Hostel::where('gender', $allot_hostel->hostel->gender)->get() as $hostel)
                                                <option value="{{ $hostel->id }}" {{ $allot_hostel->hostel->name == $hostel->name ? 'selected' : ''}}>{{ $hostel->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="new_roomcapacity[{{ $allot_hostel->id }}]">
                                            <option value="0">Select Room Capacity</option>
                                            <option value="1">Single</option>
                                            <option value="2">Double</option>
                                            <option value="3">Triple</option>
                                            <option value="4">Dormitory</option>
                                        </select>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

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
                    @if(!($hostel))
                        <div class="float-end">
                            {{ $requirements->links() }}
                        </div>
                    @endif
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
