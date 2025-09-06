<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notification Detail
                <p>
                    <a href="/notiMaster/" class="btn btn-primary btn-sm">Back</a>
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
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Date
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="dt" class="form-control"
                                value="{{ old('dt', $noti_master->dt) }}" disabled>
                        </div>
                    </div>


                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Type
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="type" class="form-control"
                                value="{{ old('type', $noti_master->type) }}" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Content
                        </div>
                        <div class="col col-md-4">
                            <textarea name="content" class="form-control" disabled>{{ old('content', $noti_master->content) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">

                        </div>
                        <div class="col col-md-4">
                            <a href="/notiMaster/{{ $noti_master->id }}/edit" class="btn btn-secondary">Edit</a>
                        </div>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Sub-categories under this notification.
                @can('manages', App\Models\Notification::class)
                    <p>
                        <a class="btn btn-primary btn-sm" href="/notiMaster/{{ $noti_master->id }}/notification/create">Create</a>
                    </p>
                @endcan
            </x-slot>
            @if (count($notifications) > 0)
                <div style="width:100%, x-overflow:auto">
                    <table class="table">
                        <tr>
                            <td>Sl.</td>
                            <td>Subject</td>
                            <td>Type</td>
                            <td>Action</td>
                        </tr>
                        <?php $sl = 1 ?>
                        @foreach($notifications as $notif)
                            <tr>
                                <td>
                                    {{ $sl++ }}
                                </td>
                                <td>
                                    <a href="/notification/{{ $notif->id }}">{{ $notif->no }}</a>
                                </td>
                                <td>
                                    {{ $notif->type }}
                                </td>
                                <td>
                                    <div class="btn-grpup">
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            @endif
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
