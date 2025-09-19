<x-layout>
    <x-container>
        <x-block class="col-md-8">
            <x-slot name="heading">
                Create new Standard Operating Procedure
            </x-slot>
            <form method="post" action="/sop/{{ $sop->id }}">
                @csrf
                @method('PUT')
                <div class="mb-2 form-group row">
                    <label for="title" class="col-md-4">
                        Title
                    </label>
                    <div class="col-md-8">
                        <input class="form-control" name='title' value="{{ $sop->title }}"  maxlength="50">
                    </div>
                </div>

                <div class="mb-2 form-group row">
                    <label for="title" class="col-md-4">
                        Content
                    </label>
                    <div class="col-md-8">
                        <textarea class="form-control" name='content' height="50">{{ $sop->content }}</textarea>
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

    <script>
        $(document).ready(function() {
            $("textarea[name='content']").summernote();
        });
    </script>
</x-layout>
