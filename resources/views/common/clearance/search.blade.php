<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Clearance.
            </x-slot>
            Steps to get the hostel clearance:
            <ol>
                <li>Clear all hostel admissions fees (Finance Department) </li>
                <li>Get the receipt and print it</li>
                <li>Clear all hostel dues - Mess and other dues.</li>
                <li>Fill the form and get it approved by Prefect/ Mess Secretary</li>
                <li>Approach Warden to issue 'Clearance Certificate'</li>
                <li>Once issued, Warden may print, or you can get your own copy by searching from below form.</li>
            </ol>
            <form method="get" action="">
                <div class="form-group bt-4">
                    <div class="col-md-4">
                        Enter clearance letter number:
                    </div>
                    <div class="col-md-4">
                        Letter No. Clearance/<input type="text" name="allotment_id" value="{{ old('allotment_id') }}"
                            size=4 required>/<input type="text" name="clearance_id" value="{{ old('clearance_id') }}"
                            size=4 required>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                </div>
            </form>
            @if (isset($clearance))
                Clearance found. Click <a
                    href="/clearance/{{ $clearance->id }}/view?allotment_id={{ $clearance->allotment_id }}">HERE</a> to
                view
                clearance.
            @elseif(isset($search))
                Clearance is not found. Please kindly approach the Warden.
            @endif
        </x-block>
    </x-container>
</x-layout>
