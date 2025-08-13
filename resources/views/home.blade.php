<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Welcome to Halls of Residence, Mizoram University
            </x-slot>
            Important notifications:
            <ul>
                <li>Application for accommodation to the Mizoram University Halls of Residence is opened.
                    To apply for the 2025-26 academic session, click <a href="/application">here</a> to go to application
                    portal.</li>
                <li>All residents who are willing to stay in the next semester should register themselves in the portal
                    and apply for seat through the portal.</a>
                <li>Hostel residents who are about to leave the University should apply for 'Clearance Certificate'
                    using the format without which clearance shall not be issued. Students who left without the
                    clearance shall not have their results declared.</li>
            </ul>
        </x-block>

        @if(App\Models\Manage::where('name', 'diktei')->where('status', 'open')->exists())
            <x-block>
                <x-slot name="heading">
                    Portal for submission of IMJ for first semester PG students
                </x-slot>
                <a class="btn btn-primary btn-large" href="/diktei">Go to Interdisciplinary Course selection</a>
            </x-block>
        @endif
    </x-container>
</x-layout>
