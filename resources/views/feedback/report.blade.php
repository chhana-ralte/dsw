<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback
            </x-slot>
            <div>
                <h4>Instructions:</h4>
                <ul>
                    <li>You are about to give feedback on {{ $feedback_master->title }}
                    <li>Each item is to be rated from 0 to 10 using the sliders.</li>
                    <li>The feedback has to be from your own opinion.</li>
                    <li>You can give only one feedback.</li>
                    <li>Your feedback can not be traced back to you.</li>
                </ul>
                <a class="btn btn-primary" href="/feedbackMaster/{{ $feedback_master->id }}/feedback/create">Proceed>></a>
            </div>
        </x-block>
    </x-container>
</x-layout>
