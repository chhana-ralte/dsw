<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Generation of Rooms for the hostels in the database
            </x-slot>
            <form method="post" action="/generateRooms">
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
