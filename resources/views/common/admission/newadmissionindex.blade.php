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
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Department</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1 ?>
                        @foreach($new_allotments as $allotment)
                            <tr class="table-white row_{{ $allotment->id }}">
                                <td>{{ $sl++ }}</td>
                                <td class="name">{{ $allotment->person->name }}</td>
                                @if($allotment->person->student())
                                    <td>{{ $allotment->person->student()->course }}</td>
                                    <td>{{ $allotment->person->student()->department }}</td>
                                @elseif($allotment->person->other())
                                    <td colspan="2"><b>Not a student ({{ $allotment->person->other()->remark }})</b></td>
                                @else
                                    <td colspan="2"><b>No info</b></td>
                                @endif
                                <td>
                                    <a class="btn btn-primary" href="/allotment/{{ $allotment->id }}/admission/create?sessn_id={{ $sessn->id }}">Admit</a>
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
