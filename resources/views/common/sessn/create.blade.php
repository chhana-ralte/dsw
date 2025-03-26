<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Session
                <p>
                    <a href="/sessn/" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/sessn">
                @csrf
                <div>
                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Start year
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="start_yr" value="{{ old('start_yr') }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            End year
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="end_yr" class="form-control" value="{{ old('end_yr') }}"  disabled>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Odd/Even
                        </div>
                        <div class="col col-md-4">
                            <select name="odd_even" class="form-control">
                                <option value="1" {{ old('odd_even')==1?' selected ':''}}>Odd</option>
                                <option value="2" {{ old('odd_even')==2?' selected ':''}}>Even</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            
                        </div>
                        <div class="col col-md-4">
                            <input type="checkbox" id="current" name="current">
                            <label for="current">Current Session?</label>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            
                        </div>
                        <div class="col col-md-4">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $("input[name='start_yr']").keyup(function(){
        if($(this).val().length >= 4){
            vl = parseInt($(this).val()) + 1;
            $("input[name='end_yr']").val(vl);
        }
    });
});
</script>
</x-layout>
