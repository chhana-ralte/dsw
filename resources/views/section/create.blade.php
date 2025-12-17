<x-layout>
    <x-container>
        <x-slot name='heading'>
            Hehe
        </x-slot>
        <form method="post" action="/section">
            @csrf
            <div class="form-group row mb-3">
                <label class="col-md-6">
                    Section name:
                </label>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-6">
                    Abbreviation (Short form):
                </label>
                <div class="col-md-6">
                    <input type="text" name="abbr" class="form-control" required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-6">
                    Sub section of:
                </label>
                <div class="col-md-6">
                    <select name="section" class="form-control">
                        <option value="0">None</option>
                        @foreach($sections as $sect)
                            <option value="{{ $sect->id }}">{{ $sect->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    <a class="btn btn-secondary" href="/section">
                        Back
                    </a>
                    <button class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </x-container>
</x-layout>