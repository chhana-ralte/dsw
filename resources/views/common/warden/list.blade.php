<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of Wardens
            </x-slot>

            @if (count($hostels) > 0)
                <table class="table">
                    <tr>
                        <th>Hostel</th>
                        <th>Warden</th>
                        @auth
                            <th>Contact</th>
                        @endauth
                        @if (auth()->user() && auth()->user()->max_role_level() >= 2)
                            <th>From</th>
                            <th>To</th>
                        @endif
                        @if (auth()->user() && auth()->user()->isAdmin())
                            <th>User</th>
                        @endif
                    </tr>

                    @foreach ($hostels as $h)
                        <tr>
                            <td style="align-content: center" rowspan="{{ count($h->valid_wardens()) > 0? count($h->valid_wardens()):1 }}">
                                @if(auth()->user() && auth()->user()->isDsw())
                                    <a href="/hostel/{{ $h->id }}/warden">{{ $h->name }}</a>
                                @else
                                    {{ $h->name }}
                                @endif
                            </td>
                            @if($h->valid_wardens()->count() == 0)
                                <td><span class="text-danger">No Warden appointed</span></td>
                            @else
                                <?php
                                    $sl=1; $row=0;
                                ?>

                                @foreach($h->valid_wardens() as $wd)
                                    @if($sl == 1)
                                        <?php $sl++ ?>
                                    @else
                                        <? $row = 1 ?>
                                        <tr>
                                    @endif
                                    <td>{{ $wd->person->name }}</td>
                                    @auth
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
                                    @endauth
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
                                    @if($row == 1)
                                        </tr>

                                    @endif

                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </table>
            @endif
        </x-block>
    </x-container>
</x-layout>
