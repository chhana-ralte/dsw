<x-layout>
    @can('given', App\Models\Antirag::class)
        <x-container>
            <x-block class="col-md-6">
                You have already given Undertaking for Anti-Ragging. Thank you.
            </x-block>
        </x-container>
    @elsecan('gives', App\Models\Antirag::class)
        <x-container>
            <x-block class="col-md-6">
                You haven't sign the Undertaking for Anti-ragging. Click <a href="/antirag/">here</a> to go to the instruction page.
            </x-block>
        </x-container>
    @endcan
    @if(App\Models\Manage::where('name', 'application')->where('status', 'open')->exists())
        <x-container>
            <x-block class="col-md-6">
                <h3>
                    Welcome to the Halls of Residence, Mizoram University
                </h3>
                <p>
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
                </p>
            </x-block>
        </x-container>
    @endif
    {{-- @if(App\Models\Manage::where('name', 'diktei')->where('status', 'open')->exists())
        <x-block>
            <x-slot name="heading">
                Portal for submission of IMJ for first semester PG students
            </x-slot>
            <a class="btn btn-primary btn-large" href="/diktei">Go to Interdisciplinary Course selection</a>
        </x-block>
    @endif --}}

    @can('gives', App\Models\Feedback::class)

        @if(App\Models\Feedback::feedback_done(auth()->user()->id))
            <div class="mt-5 mb-3 container ">
                <x-alert type="success">Feedback already done. Thank you</x-alert>
            </div>

        @else
            <x-container>
                <x-block class="col-md-6">
                    <x-slot name="heading">
                        Feedback on mess quality to be given.
                    </x-slot>
                    <p>
                        Important notes to boarders:
                        <ul>
                            <li>Students residing in the hostels are required to give the feedback on the quality of mess provided since September, 2024.</li>
                            <li>All boarders are expected to give their feedback on the basis of their experience only. They should not be under any pressure or campaign.</a>
                            <li>All concerned are requested to be free from campaigning to give good/ bad feedback, and those involved in that activity shall be immediately reported to the Mess Quality Control Committee.</li>
                            <li>Click the below button to start.</li>
                            <li><a class="btn btn-primary" href="/feedbackMaster/1/feedback">Start &gt;&gt;</a></li>
                        </ul>
                    </p>
                </x-block>
            </x-container>
        @endif

    @endcan
    @can('views', App\Models\Feedback::class)
        <x-container>
            <x-block class="col-md-6">
                Click <a href="/feedbackMaster/1/report/">here</a> to view the feedback responses
            </x-block>
        </x-container>
    @endcan

    
</x-layout>
