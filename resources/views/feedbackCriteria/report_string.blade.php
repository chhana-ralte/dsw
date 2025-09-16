<x-layout>
    <x-container>
        <x-block class="col-md-8">
            <x-slot name="heading">
                Feedback criteria detailed reports.
                <p>
                    <a href="/feedbackMaster/{{ $feedbackCriterion->feedback_master->id }}/report"
                        class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>

            <h4 class="px-3 py-1">{{ $feedbackCriterion->criteria }}</h4>
            @foreach ($strings as $str)
                @if ($str->string != '')
                    <div class="p-2 mx-3 my-2 border rounded-3 text-muted">
                        {!! nl2br($str->string) !!}
                        <div class="small text-danger">
                            -
                            {{ $str->feedback_detail->feedback->user->allotment()->valid_allot_hostel()->hostel->name }}
                        </div>
                    </div>
                @endif
            @endforeach
            <div>
                {{ $strings->links() }}
            </div>
        </x-block>
    </x-container>
</x-layout>
