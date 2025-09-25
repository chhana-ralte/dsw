<x-layout>
    <x-container>
        <x-block class="col-md-8">
            <x-slot name="heading">
                Standard Operating Procedure
                <p>
                    <a class="btn btn-secondary btn-sm" href="/sop">Back</a>
                </p>
            </x-slot>
            <div>
                <p class="text-center h3 strong">
                    {{ $sop->title }}
                </p>
                <hr>
                <p>
                    {!! $sop->content !!}
                </p>
                    
                @can('manages', App\Models\Sop::class)
                    <div class="btn-group">
                        <a class="btn btn-secondary btn-sm" href="/sop/{{ $sop->id }}/edit">Edit</a>
                        <button class="btn btn-danger btn-sm btn-delete" value="{{ $sop->id }}">Delete</button>

                    </div>
                    <form method="post" name="delete_sop" action="/sop/{{ $sop->id }}">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="sop_id">
                    </form>
                @endcan
                

            </div>


        </x-block>
    </x-container>
    <x-container>
        <x-block class="col-md-8">
            <x-slot name="heading">
                Related files in the SOP

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
            @can('manages', App\Models\Sop::class)
                <button class="btn btn-primary addfile">Add file</button>
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
                    <form method="post" action="/sop/fileupload" name="frmFileUpload" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sop_id" value="{{ $sop->id }}">
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
            $("button.addfile").click(function() {
                $("div#fileUploadModal").modal("show");
            });

            $("button.btn-upload").click(function() {
                $("form[name='frmFileUpload']").submit();
            });

            $("button.btn-delete").click(function() {
                if (confirm("Are you sure you want to delete this SOP?")) {
                    $("input[name='sop_id']").val($(this).val());
                    $("form[name='delete_sop']").attr('action', '/sop/' + $(this).val());
                    $("form[name='delete_sop']").submit();
                }
            });

        });
    </script>
</x-layout>
