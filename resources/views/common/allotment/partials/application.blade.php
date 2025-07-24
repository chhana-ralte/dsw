<x-slot name="heading">
    Application status
</x-slot>


<table class="table table-auto">
    <tr>
        <td>Application ID</td>
        <td>
            <a href="/application/{{ $allotment->application->id }}?mzuid={{ $allotment->application->mzuid }}">
                {{ $allotment->application->id }}
            </a>
        </td>
    </tr>
    <tr>
        <td>Status</td>
        <td>{{ $allotment->application->status }}</td>
    </tr>
</table>
