<x-slot name="heading">
    Student Information
    @auth()
        @can('edit', $allotment->person)
            <a class="btn btn-secondary btn-sm"
                href="/student/{{ $allotment->person->student()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
        @endcan
        @if (auth()->user()->isAdmin())
            <button form="frm_delete" class="btn btn-danger btn-sm">Delete student info</a>
                <form id="frm_delete" method="post"
                    action="/student/{{ $allotment->person->student()->id }}"
                    onsubmit="return confirm('Are you sure you want to delete student information of this person?')">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="back_link" value="/allotment/{{ $allotment->id }}">
                </form>
        @endif
    @endauth
</x-slot>
<table class="table table-auto">
    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
        <td>Rollno</td>
        <td>{{ $allotment->person->student()->rollno }}</td>
    </tr>
    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
        <td>Course name</td>
        <td>{{ $allotment->person->student()->course }}</td>
    </tr>
    <tr>
        <td>Department</td>
        <td>{{ $allotment->person->student()->department }}</td>
    </tr>
    </tr>
    <td>MZU ID</td>
    <td>{{ $allotment->person->student()->mzuid }}</td>
    </tr>
</table>
