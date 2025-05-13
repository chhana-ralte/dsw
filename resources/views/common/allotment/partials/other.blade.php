<x-slot name="heading">
    Other informations
    @auth()
        @can('update', $current_hostel)
            <a class="btn btn-secondary btn-sm"
                href="/other/{{ $allotment->person->other()->id }}/edit?back_link=/allotment/{{ $allotment->id }}">Edit</a>
        @endcan
        @if (auth()->user()->isAdmin())
            <button type="submit" class="btn btn-danger btn-sm" form="frm_delete">Delete other info</a>
                <form id="frm_delete" method="post" action="/other/{{ $allotment->person->other()->id }}"
                    onsubmit="return confirm('Are you sure you want to delete other information of this person?')">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="back_link" value="/allotment/{{ $allotment->id }}">
                </form>
        @endif
    @endauth
</x-slot>
<table class="table table-auto table-striped">
    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
        <td>{{ $allotment->person->other()->remark }}</td>
    </tr>
</table>
