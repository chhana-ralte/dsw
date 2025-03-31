<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Session
                <p>
                    <a href="/notification/" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/notification">
                @csrf
                <div>
                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Notification No.
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="no" value="{{ old('no') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Date
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="dt" class="form-control" value="{{ old('dt') }}" required>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Content
                        </div>
                        <div class="col col-md-4">
                            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
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
