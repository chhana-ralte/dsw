<x-layout>
    <x-container>
        <x-block class="col-md-6">
            <x-slot name="heading">
                Standard Operating Procedure
            </x-slot>
            <div>
                <div class="form-group row mb-2">
                    <label for="title" class="col-md-4">
                        Title
                    </label>
                    <div class="col-md-8">
                        {{ $sop->title }}
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label for="title" class="col-md-4">
                        Content
                    </label>
                    <div class="col-md-8">
                        {{ $sop->content }}
                    </div>
                </div>


            </div>


        </x-block>
    </x-container>
    <x-container>
        <x-block class="col-md-6">
            <x-slot name="heading">
                Files in the SOP

            </x-slot>
            <div>
                @foreach($filelinks as $fl)
                    <a class="btn btn-primary" href="{{ $fl->file->path }}">{{ $fl->tagname }}</a>
                @endforeach
            </div>
            <button class="btn btn-primary addfile">Add file</button>
        </x-block>
    </x-container>
{{-- Modal for file uploading --}}
    <div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
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
    $(document).ready(function(){
        $("button.addfile").click(function(){
            $("div#fileUploadModal").modal("show");
        });

        $("button.btn-upload").click(function(){
            $("form[name='frmFileUpload']").submit();
        });

    });
</script>
</x-layout>
