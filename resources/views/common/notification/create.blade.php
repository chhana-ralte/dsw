<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Notification
                <p>
                    <a href="/notification/" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/notiMaster/{{ $noti_master->id }}/notification">
                <input type="hidden" name="noti_master_id" value="{{ $noti_master->id }}">
                @csrf
                <div>
                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Notification Master
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="no" value="{{ $noti_master->no }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Date of notification
                        </div>
                        <div class="col col-md-4">
                            <input type="text" value="{{ $noti_master->dt }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Type of notification
                        </div>
                        <div class="col col-md-4">
                            <input type="text" value="{{ $noti_master->type }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Sub-Notification
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="no" value="{{ old('no') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Content
                        </div>
                        <div class="col col-md-4">
                            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Type
                        </div>
                        <div class="col col-md-4">
                            <select name="type" class="form-control">
                                <option value="allotment">New allotments</option>
                                <option value="sem_allot">Semester-wise allotments</option>
                            </select>

                        </div>
                    </div>

                    <div class="pt-3 form-group row">
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
