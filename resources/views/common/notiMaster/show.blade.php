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
    @if($noti_master->type == 'allotment' || $noti_master->type == 'sem_allot')
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
    @endif
    <x-container>
        <x-block>
            <x-slot name="heading">
                Files associated with the notification
            </x-slot>
            <div class="mb-3">
                @foreach ($filelinks as $fl)
                    <a href="{{ $fl->file->path }}" target="_blank">
                        <span class="badge rounded-pill bg-primary">
                            {{ $fl->tagname }}
                        </span>
                    </a>
                @endforeach
            </div>
            @can('manages', App\Models\Notification::class)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileUploadModal">Add file</button>
                {{-- <button class="btn btn-primary addfile">Add file</button> --}}
            @endcan
        </x-block>
    </x-container>
        {{-- Modal for file uploading --}}
    <div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileUploadModalLabel">File Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/noti_master/fileupload" name="frmFileUpload" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="noti_master_id" value="{{ $noti_master->id }}">
                        <div class="mb-3">
                            <label for="file" class="col-form-label">file:</label>
                            <input class="form-control" type="file" id="file" name="file">
                        </div>
                        <div class="mb-3">
                            <label for="filename" class="col-form-label">Filename:</label>
                            <input class="form-control" id="filename" name="filename">
                        </div>
                        <div class="mb-3">
                            <label for="tagname" class="col-form-label">File tag:</label>
                            <input class="form-control" id="tagname" name="tagname">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-upload">Upload</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for file uploading --}}
    <script>
        $(document).ready(function() {
            $("input[name='start_yr']").keyup(function() {
                if ($(this).val().length >= 4) {
                    vl = parseInt($(this).val()) + 1;
                    $("input[name='end_yr']").val(vl);
                }
            });

            $("button.btn-upload").click(function() {
                $("form[name='frmFileUpload']").submit();
            });
        });
    </script>
</x-layout>
