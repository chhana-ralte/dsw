<x-slot name="heading">
    @if ($allotment->person->requirement(App\Models\Sessn::current()->id))
        <strong class="text-success">Requirement already submitted. click <a
                href="/allotment/{{ $allotment->id }}/requirement">here</a> to view/edit</strong>
    @else
        <strong class="text-danger">Requirement not submitted yet. </strong>
        @if($allotment->user() && $allotment->user()->id == auth()->user()->id)
            <strong class="text-danger"> Click <a href="/allotment/{{ $allotment->id }}/requirement">here</a> to submit</strong>
        @endif
    @endif
</x-slot>
