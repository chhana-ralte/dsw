<x-layout>
    <x-container>
        <x-block class="col-md-6">
            <x-slot name="heading">
                Create new Standard Operating Procedure
            </x-slot>
            <form method="post" action="/sop">
                @csrf
                <div class="mb-2 form-group row">
                    <label for="title" class="col-md-4">
                        Title
                    </label>
                    <div class="col-md-8">
                        <input class="form-control" name='title' maxlength="50">
                    </div>
                </div>

                <div class="mb-2 form-group row">
                    <label for="title" class="col-md-4">
                        Content
                    </label>
                    <div class="col-md-8">
                        <textarea class="form-control" name='content'></textarea>
                    </div>
                </div>

                <div class="mb-2 form-group row">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("textarea[name='content']").summernote();
        });
    </script>
</x-layout>
