<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                Select the Hostel
                {{-- <p>
                    <a class="btn btn-primary btn-sm" href="/section/create">
                        asdasd
                    </a>
                </p> --}}
            </x-slot>
            <table class="table">
                <tr>
                    <th>Sl</th>
                    <th>Hostel</th>
                    <th>Gender</th>
                    <th>Null</th>

                    <th>Forwarded</th>
                    <th>Sent</th>
                    <th>Paid</th>
                    <th>Cancelled</th>
                </tr>
                <?php $sl=1 ?>
                @foreach($semfees as $h)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>

                            <a href="/semfee?hostel_id={{ $h->id }}">{{ $h->name }}</a>

                        </td>
                        <td>
                            {{ $h->gender }}
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->isFinance())
                                <a href="/semfee/list/hostel/{{ $h->id }}/Null">
                                    {{ $h->Null }}
                                </a>
                            @else
                                {{ $h->Null }}
                            @endif
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->isFinance())
                                <a href="/semfee/list/hostel/{{ $h->id }}/Forwarded">
                                    {{ $h->Forwarded }}
                                </a>
                            @else
                                {{ $h->Forwarded }}
                            @endif
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->isFinance())
                                <a href="/semfee/list/hostel/{{ $h->id }}/Sent">
                                    {{ $h->Sent }}
                                </a>
                            @else
                                {{ $h->Sent }}
                            @endif
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->isFinance())
                                <a href="/semfee/list/hostel/{{ $h->id }}/Paid">
                                    {{ $h->Paid }}
                                </a>
                            @else
                                {{ $h->Paid }}
                            @endif
                        </td>
                        <td>
                            @if(auth()->user() && auth()->user()->isFinance())
                                <a href="/semfee/list/hostel/{{ $h->id }}/Cancelled">
                                    {{ $h->Cancelled }}
                                </a>
                            @else
                                {{ $h->Cancelled }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-block>
    </x-container>
</x-layout>
