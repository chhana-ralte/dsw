<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Alllotment of seats in mass from dumped data.
            </x-slot>
            <form method="post" action="/massAllot">
                @csrf
                <div class="form-group row mb-3">
                    <div class="col col-md-4">Enter password</div>
                    <div class="col col-md-4">
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-4"></div>
                    <div class="col col-md-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
        </x-block>
    </x-container>
</x-layout>
