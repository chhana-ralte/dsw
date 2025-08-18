<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Select students and select the file.

                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ url()->previous()}}">
                        Back
                    </a>
                </p>

            </x-slot>

            <div style="width: 100%; overflow-x:auto">
                <form name="frm-submit" method="post" action="/requirement/list">
                    @csrf
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="action">
                    <input type="hidden" name="hostel_id" value="{{ $hostel?$hostel->id:0 }}">
                    <div id="file-info">
                        <div class="mb-3 form-group row">
                            <label class="col-md-5">File number</label>
                            <div class="col md-7">
                                <select name="filemaster" class="form-control">
                                    <option value="0" selected disabled>Select the file</option>
                                    @foreach(App\Models\NotiMaster::where('type', 'sem_allot')->get() as $nm)
                                        <option value="{{ $nm->id }}">{{ $nm->no }}:{{ $nm->dt }}: {{ $nm->content }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 form-group row">
                            <label class="col-md-5">Sub-file number</label>
                            <div class="col md-7">
                                <select name="file" class="form-control">
                                    <option value="0">New file</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label class="col-md-5">Enter file number</label>
                            <div class="col md-7">
                                <input type="text" class="form-control" name="no">
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label class="col-md-5">Enter file date</label>
                            <div class="col md-7">
                                <input type="date" class="form-control" name="dt">
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label class="col-md-5">Enter subject</label>
                            <div class="col md-7">
                                <input type="text" class="form-control" name="subject">
                            </div>
                        </div>
                    </div>
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="all"></th>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Student info</th>
                                <th>Requirement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1 ?>
                            @foreach ($requirements as $req)
                                <tr>

                                    <td>

                                        <input type="checkbox" name="requirement_id[]" value="{{ $req->id }}" checked>

                                    </td>
                                    <td>{{ $sl++ }}</td>
                                    <td>

                                        {{ $req->person->name }}

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
                                        Hostel: {{ $req->new_hostel->name }}<br>
                                        Type: {{ App\Models\Room::room_type($req->new_roomcapacity) }}<br>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <footer>
                            <tr>
                                <td colspan="6">
                                    @if(auth()->user()->can('resolves', App\Models\Requirement::class) || auth()->user()->isWardenOf($hostel?$hostel->id:0))
                                        <button class="btn btn-primary btn-action" type="button" value="notify">Confirm</button>
                                    @endif

                                </td>
                            </tr>
                        </footer>
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
{{-- Modal for duplicate requirement --}}



    <script>
        $(document).ready(function(){
            $.ajaxSetup({
               headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               }
            });

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
                    exit();
                }

                if($("select[name='file']").val() == 0 && ($("input[name='no']").val() == '' || $("input[name='dt']").val() == '' || $("input[name='subject']").val() == '')){
                    alert("Enter file number, date and subject to proceed.");
                    exit();
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

            $("select[name='filemaster']").change(function(){
                $.ajax({
                    url : '/ajax/notiMaster/' + $(this).val() + '/getNotifications',
                    type : 'get',
                    success : function(data, status){
                        var s = "<option value='0' selected>New File</option>";
                            for (i = 0; i < data.length; i++) {
                                s += "<option value='" + data[i].id + "'>" + data[i].no + "</option>";
                            }
                            $("select[name='file']").html(s);
                    },
                    error : function(){
                        alert('Error');
                    },
                });
            });

            $("select[name='file']").change(function(){
                if($(this).val() == 0){
                    $("input[name='no']").prop('disabled',false);
                    $("input[name='dt']").prop('disabled',false);
                    $("input[name='subject']").prop('disabled',false);
                }
                else{
                    $("input[name='no']").prop('disabled',true);
                    $("input[name='dt']").prop('disabled',true);
                    $("input[name='subject']").prop('disabled',true);
                }
            })


        });
    </script>
</x-layout>
