<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Hostel change application
                <p>
                    <a class="btn btn-primary btn-sm" href="/allot_hostel/{{ $allot_hostel->id }}/req">Index</a>
                </p>
            </x-slot>
            <div style="width: 100%, overflow-x: auto">
                <form method="post" action="/allot_hostel/{{ $allot_hostel->id }}/req">
                    @csrf
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="from_hostel">Current hostel</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="from_hostel" class="form-control" value="{{ $allot_hostel->hostel->name }}" readonly>
                            <input type="hidden" name="from_hostel_id" value="{{ $allot_hostel->hostel->id }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="from_hostel">To be shifted to</label>
                        </div>
                        <div class="col col-md-4">
                            <select class="form-control" name="to_hostel_id">
                                <option disabled>Select Hostel</option>
                                @foreach($hostels as $h)
                                    <option value="{{ $h->id }}">{{ $h->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col col-md-4">
                        </div>
                        <div class="col col-md-4">
                            <button class="btn btn-primary" type="submit">
                                @can('edit', $allot_hostel->allotment)
                                    Forward
                                @else
                                    Apply
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {


        });
    </script>
</x-layout>
