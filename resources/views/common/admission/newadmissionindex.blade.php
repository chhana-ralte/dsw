<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Newly allotted inmates of {{ $hostel->name }} Hall of Residence for the {{ $sessn->name() }} session.
                <p>
                    <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    @if($adm_type == 'old')
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}&adm_type=new">New admissions</a>
                    @else
                        <a class="btn btn-secondary btn-sm" href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}">Existing admissions</a>
                    @endif
                    <input style="font-size:15px" type="text" name="find"/>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Seat No.</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($new_allotments as $allotment)
                            <tr class="table-white row_{{ $ah->id }}">
                                <td><i>N.A.</i></td>
                                <td class="name">{{ $allotment->person->name }}</td>
                                @if($allotment->person->student())
                                    <td>{{ $allotment->person->student()->department }}</td>
                                @elseif($person->other())
                                    <td><b>Not a student ({{ $allotment->person->other()->remark }})</b></td>
                                @else
                                    <td><b>No info</b></td>
                                @endif
                                <td>
                                    @if($allotment->admission($sessn->id))
                                        <label id="label_{{ $allotment->id }}">Done</label>
                                        @can('update',$hostel)
                                            <button class="btn btn-primary btn-sm btn-confirm" name="admit_{{ $allotment->id }}" value="{{ $allotment->id }}">Undo</button>
                                        @endcan
                                    @else
                                        <label id="label_{{ $allotment->id }}">Not done</label>
                                        @can('update',$hostel)
                                            <button class="btn btn-primary btn-sm btn-confirm" name="admit_{{ $allotment->id }}" value="{{ $allotment->id }}">Confirm</button>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });
    $("button.btn-confirm").click(function(){
        id = $(this).val();

        $.ajax({
            url : "/ajax/manage_admission",
            type : "post",
            data : {
                'undo' : $("button.btn-confirm[name='admit_"+ id +"']").text() == "Undo"?1:0,
                'sessn_id' : {{ $sessn->id }},
                'allot_hostel_id' : $(this).val()
            },
            success : function(data,status){

                if(data.undo == 1){
                    $("label#label_" + data.allot_hostel_id).text("Not done");
                    $("button[name='admit_" + data.allot_hostel_id + "']").text("Confirm");

                }
                else{
                    $("label#label_" + data.allot_hostel_id).text("Done");
                    $("button[name='admit_" + data.allot_hostel_id + "']").text("Undo");

                }
            },
            error : function(){
                alert("Error");
            }
        });
        // alert($(this).val());
    });

    $("input[name='find']").on("keyup", function() {
        var pattern = $(this).val();

        $("table tr").each(function(index) {
            if (index != 0) {
                $row = $(this);
                var text = $row.find("td.name").text().toLowerCase().trim();
                if(text.match(pattern)){
                    $(this).show();
                }
                else{
                    $(this).hide();
                }
            }
        });
    });
});
</script>
</x-layout>
