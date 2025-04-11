<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Editing personal info: {{ $person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Editing personal details
            </x-slot>
            <form method="post" action="/person/{{ $person->id }}">
                @method("PUT")
                @csrf
                <input type='hidden' name='back_link' value="{{ $back_link }}">
                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Name</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ old('name',$person->name) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="father" class="col col-md-3">Father/Guardian</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="father" value="{{ old('father',$person->father) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="mobile" class="col col-md-3">Mobile</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile',$person->mobile) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="email" class="col col-md-3">Email</label>
                    <div class="col col-md-4">
                        <input type="email" class="form-control" name="email" value="{{ old('email',$person->email) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="category" class="col col-md-3">Category</label>
                    <div class="col col-md-4">
                        <select name='category' class='form-control'>
                            <option>Select Category</option>
                            <option value='General' {{ $person->category=='General'?' selected ':''}}>General</option>
                            <option value='OBC' {{ $person->category=='OBC'?' selected ':''}}>OBC</option>
                            <option value='SC' {{ $person->category=='SC'?' selected ':''}}>SC</option>
                            <option value='ST' {{ $person->category=='ST'?' selected ':''}}>ST</option>
                            <option value='EWS' {{ $person->category=='EWS'?' selected ':''}}>EWS</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="state" class="col col-md-3">State</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="state" value="{{ old('state',$person->state) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="address" class="col col-md-3">Address</label>
                    <div class="col col-md-4">
                        <textarea class="form-control" name="address">{{ old('address',$person->address) }}</textarea>
                            
                        
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <a class="btn btn-secondary" href="{{ $back_link }}">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="update">Update</update>
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
