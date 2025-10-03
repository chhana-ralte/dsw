<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Copy and paste the declaration link here...
            </x-slot>
            <form method="post" action="/antirag">
                @csrf
                <div class="formgroup row mb-3">
                    <label for="link" class="col col-md-4">
                        Link
                    </label>
                    <div class="col col-md-8">
                        <input class="form-control" type="text" name="link">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="link" class="col col-md-4">
                        
                    </label>
                    <div class="col col-md-8">
                        <button class="btn btn-primary btn-submit">Submit</button>
                    </div>
                </div>
            </div>
        </x-block>
    </x-container>
</x-layout>