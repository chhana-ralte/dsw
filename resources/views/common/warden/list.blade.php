<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of Wardens
            </x-slot>

            @if (count($wardens) > 0)
                <table class="table">
                    <tr>
                        <th>Hostel</th>
                        <th>Warden</th>
                        <th>Contact</th>
                        @if (auth()->user() && auth()->user()->max_role_level() >= 2)
                            <th>From</th>
                            <th>To</th>
                        @endif
                        @if (auth()->user() && auth()->user()->isAdmin())
                            <th>User</th>
                        @endif
                    </tr>

                    @foreach ($wardens as $wd)
                        <tr>
                            <td>{{ $wd->hostel->name }}</td>
                            <td>{{ $wd->person->name }}</td>
                            <td>
                                @if ($wd->person->mobile)
                                    Mobile: <a href="tel:{{ $wd->person->mobile }}">{{ $wd->person->mobile }}</a>
                                @else
                                    Not provided
                                @endif
                                @if ($wd->person->email)
                                    <br>
                                    email: <a href="mailto:{{ $wd->person->email }}">{{ $wd->person->email }}</a>
                                @else
                                    Not provided
                                @endif
                            </td>
                            @if (auth()->user() && auth()->user()->max_role_level() >= 2)
                                <td>{{ $wd->from_dt }}</td>
                                <td>{{ $wd->to_dt }}</td>
                            @endif
                            @can('manage', $wd)
                                <td>
                                    @if ($wd->user())
                                        <a href="/">{{ $wd->user()->username }}</a>
                                    @else
                                        <a class="btn btn-primary btn-sm"
                                            href="/user/create?type=warden&id={{ $wd->id }}">Create user</a>
                                    @endif
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </table>
            @endif
        </x-block>
    </x-container>
</x-layout>
