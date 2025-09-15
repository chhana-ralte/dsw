<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Standard Operating Procedures
                <p>
                    <a class="btn btn-primary btn-sm" href="/sop/create">Create new</a>
                </p>
            </x-slot>
            @foreach($sops as $sop)
                <div class="form-group row">
                    <label for="title" class="col-md-4">
                        <strong>Title</strong>
                    </label>
                    <label for="title" class="col-md-8">
                        <strong>Content</strong>
                    </label>

                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <a href="/sop/{{ $sop->id }}">{{ $sop->title }}</a>
                    </div>

                    <div class="col-md-8">
                        {{ substr($sop->content,0, 100) }}
                    </div>
                </div>
            @endforeach
        </x-block>
    </x-container>
</x-layout>
