<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ $query->title }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/query/">Back</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x: auto">
                <form method="post" action="/query/exec">
                    {{-- @method('put') --}}
                    @csrf
                    <input type="hidden" name="query_id" value="{{ $query->id }}">
                    <div class="form-group row mb-3">
                        <label class="col col-md-4">Title</label>
                        <div class="col col-md-8">
                            <input class="form-control" type="text" name='title' value="{{ $query->title }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col col-md-4">SQL</label>
                        <div class="col col-md-8">
                            <textarea class="form-control" name="sql">{{ $query->sql }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col col-md-4">Action</label>
                        <div class="col col-md-8">
                            <button class="btn btn-primary" type="button">Create</button>
                            <button class="btn btn-primary" type="submit">Go</button>
                        </div>
                    </div>
                </form>
            </div>
            @include('query.partial.results')
        </x-block>
    </x-container>
</x-layout>
