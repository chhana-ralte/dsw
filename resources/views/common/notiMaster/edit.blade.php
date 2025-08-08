<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notification Detail
                <p>
                    <a href="/notiMaster/{{ $noti_master->id }}" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/notiMaster/{{ $noti_master->id }}">
                @method('PUT')
                @csrf
                <div>
                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Notification No.
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="no" value="{{ old('no', $noti_master->no) }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Date
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="dt" class="form-control"
                                value="{{ old('dt', $noti_master->dt) }}">
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Type
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="type" class="form-control"
                                value="{{ old('type', $noti_master->type) }}">
                        </div>
                    </div>


                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Content
                        </div>
                        <div class="col col-md-4">
                            <textarea name="content" class="form-control">{{ old('content', $noti_master->content) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">

                        </div>
                        <div class="col col-md-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </x-block>


    </x-container>
    <script>
        $(document).ready(function() {
            $("input[name='start_yr']").keyup(function() {
                if ($(this).val().length >= 4) {
                    vl = parseInt($(this).val()) + 1;
                    $("input[name='end_yr']").val(vl);
                }
            });
        });
    </script>
</x-layout>
