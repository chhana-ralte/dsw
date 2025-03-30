<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Entering student's info for: {{ $person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Student's details
            </x-slot>
            <form method="post" action="/person/{{ $person->id }}/student/">
                @csrf
                <input type='hidden' name='back_link' value="{{ $back_link }}">
                <div class="form-group row mb-3">
                    <label for="rollno" class="col col-md-3">Rollno</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="rollno" value="{{ old('rollno') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="course" class="col col-md-3">Course</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="course" value="{{ old('course') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="department" class="col col-md-3">Department</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="department" value="{{ old('department') }}">
                    </div>
                </div>

                
                <div class="form-group row mb-3">
                    <label for="mzuid" class="col col-md-3">MZU ID</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mzuid" value="{{ old('mzuid') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <a class="btn btn-secondary" href="{{ $back_link }}">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="create">Create</update>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });

    $("button#unavailable").click(function(){
        $("form#unavailabl").submit();
    });
    
    $("a.deallocate").click(function(){
        if(confirm("Are you sure you want to deallocate this student from the existing seat?")){
            $.ajax({
                type : "post",
                url : "/ajax/seat/" + $(this).attr("id") + "/deallocate",
                
                success : function(data,status){
                    if(data == "Success"){
                        alert("Deallocation successful");
                        location.replace("/person/{{ $person->id }}");
                    }
                },
                error : function(){
                    alert("Error");
                }
            });
        }
        //alert($(this).attr('id'));
    });
});
</script>
</x-layout>
