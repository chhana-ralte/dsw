<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Run your query
                <p>
                    <a class="btn btn-secondary btn-sm" href="/query/">Back</a>
                </p>
            </x-slot>
            <div>
                <form method="post" action="/query/exec">
                    @csrf
                    <input type="hidden" name="query_id" value="0">
                    {{-- <div class="form-group row mb-3">
                        <label class="col col-md-4">SQL</label>
                        <div class="col col-md-8">
                            <textarea class="form-control" name="sql">{{ $sql }}</textarea>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="sql">{{ $sql }}</textarea>
                        <label for="sql">SQL Query</label>
                    </div> --}}
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="sql" placeholder="Write the SQL Query here">{{ $sql }}</textarea>
                        <label for="floatingTextarea">SQL Query</label>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col col-md-4"></label>
                        <div class="col col-md-8">
                            <button class="btn btn-primary" type="submit">Go</button>
                            <button class="btn btn-primary btn-save-query" type="button">Save query</button>
                        </div>
                    </div>
                </form>
            </div>
            @include('query.partial.results')
        </x-block>
    </x-container>
    {{-- Modal for save query --}}
    <div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarkModalLabel">Add/ Edit remark</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="sql" class="col-form-label">Query:</label>
                            <textarea class="form-control" readonly id="sql"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for save query --}}
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $(".btn-save-query").click(function(){
                $("#title").val('');
                $("#sql").text($("textarea[name='sql']").val());
                $("#remarkModal").modal("show");
            });
            $(".btn-save").click(function(){
                if($("#title").val() != ""){
                    $.ajax({
                        method : 'post',
                        url : '/query?ajax=1',
                        data : {
                            title : $("#title").val(),
                            sql : $("#sql").val(),
                        },
                        success : function(data, status){
                            console.log(data);
                            $("#remarkModal").modal("hide");
                        },
                        error : function(){
                            alert("Error");
                        }
                    });
                }


            });
        });
    </script>
</x-layout>
