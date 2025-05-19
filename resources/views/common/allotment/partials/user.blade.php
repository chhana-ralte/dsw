<x-slot name="heading">
    User information about the student
</x-slot>
@if($allotment->user())
    <table class="table">
        <tr>
            <td>Username</td>
            <td>{{ $allotment->user()->username }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <a class="btn btn-primary" href="/user/{{ $allotment->user()->id }}/changePassword">Reset password</a>
                <a class="btn btn-primary" href="/user/{{ $allotment->user()->id }}/edit">Edit User</a>
            </td>
        </tr>
    </table>
@else
    User not available
@endif
