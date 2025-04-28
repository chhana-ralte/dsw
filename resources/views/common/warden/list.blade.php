<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of Wardens
            </x-slot>

            @if(count($wardens) > 0)
                <table class="table">
                    <tr>
                        <th>Hostel</th>
                        <th>Warden</th>
                        <th>From</th>
                        <th>To</th>
                        @if(auth() && auth()->user()->isAdmin())
                            <th>User</th>
                        @endif
                    </tr>

                    @foreach($wardens as $wd)
                        <tr>
                            <td>{{ $wd->hostel->name }}</td>
                            <td>{{ $wd->person->name }}</td>
                            <td>{{ $wd->from_dt }}</td>
                            <td>{{ $wd->to_dt }}</td>
                            @can('manage',$wd)
                                <td>
                                    @if($wd->user())
                                        <a href="/">{{ $wd->user()->username }}</a>
                                    @else
                                        <a class="btn btn-primary btn-sm" href="/user/create?type=warden&id={{ $wd->id }}">Create user</a>
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
