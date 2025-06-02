<x-slot name="heading">
    @if ($allotment->person->requirement(App\Models\Sessn::current()->next()->id))
        <strong class="text-success">Requirement already submitted. click <a
                href="/allotment/{{ $allotment->id }}/requirement">here</a> to view/edit</strong>
    @else
        <strong class="text-danger">Requirement not submitted yet. click <a
                href="/allotment/{{ $allotment->id }}/requirement">here</a> to submit</strong>
    @endif
</x-slot>
