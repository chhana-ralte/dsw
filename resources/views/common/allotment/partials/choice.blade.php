<x-slot name="heading">
    Whether a student or not??
</x-slot>
<div>
    <a href="/person/{{ $allotment->person->id }}/student/create?back_link=/allotment/{{ $allotment->id }}"
        class="btn btn-primary">Add student information</a>
    <a href="/person/{{ $allotment->person->id }}/other/create?back_link=/allotment/{{ $allotment->id }}"
        class="btn btn-primary">Not a student</a>
</div>
