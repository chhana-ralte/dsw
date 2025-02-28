<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Remarks about seat sl.: {{ $seat->serial }} of Room: {{ $seat->room->roomno }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/seat/{{ $seat->id }}">back</a>
                </p>
            </x-slot>
            @if(count($seat->remarks)>0)
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                        <th>Date</th><th>Remark</th><tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seat->remarks as $rm)
                            <td>{{ $rm->remark_dt }}</td>
                            <td>{{ $rm->remark }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                No Remark available
            @endif
            <div class="container">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="remark" name="remark" placeholder="Remark goes here" required></textarea>
                    <label for="remark">Remarks</label>
                </div>
                <div class="form-group row">
                    <div class="col col-md-4">
                        <button class="btn btn-primary add">Add remark</button>
                    </div>
                </div>
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

    $("button.add").click(function(){
        if($("#remark").val() != ""){
            $.ajax({
                type : "post",
                url : "/seat/" + {{ $seat->id }} + "/remark",
                data : {
                    remark : $("#remark").val()
                },
                success : function(data,status){
                    alert("Successful");
                    location.replace("/seat/" + data + "/remark");
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });
});
</script>
</x-layout>
