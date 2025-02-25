<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                {{ $hostel->name }} Hall of Residence
            </x-slot>

            <section id="Menu">
                <div class="container">     
                    <div class="row mb-4">
                        <a class="col-sm-3 bg-primary" href="/hostel/{{ $hostel->id }}/room">
                            <div class="col col-md-4 bg-primary  mx-auto">
                                <span class="btn btn-primary">
                                    <h4>Rooms</h4>
                                </span>
                            </div>
                        </a>
                        <a class="col-sm-3 bg-secondary" href="/hostel/{{ $hostel->id }}/occupants">
                            <div class="col col-md-4 mx-auto">
                                <span class="btn btn-secondary">
                                    <h4>Occupants</h4>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </x-block>
    </x-container>
</x-layout>
