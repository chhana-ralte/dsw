<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                Semester fee payment status for academic session
                <select name='sessn_id'>
                @foreach(\App\Models\Sessn::orderBy('start_yr')->orderBy('odd_even')->get() as $ssn)
                    <option value="{{$ssn->id}}" {{ $ssn->id == $sessn->id ? ' selected ':''}}>{{ $ssn->name() }}</option>
                @endforeach
                </select>
                {{-- <p>
                    <a class="btn btn-primary btn-sm" href="/section/create">
                        asdasd
                    </a>
                </p> --}}
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
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

                                <a href="/hostel/{{ $h->id }}/semfee?sessn={{ $sessn->id }}">{{ $h->name }}</a>

                            </td>
                            <td>
                                {{ $h->gender }}
                            </td>
                            <td>
                                @if(auth()->user() && auth()->user()->isFinance())
                                    <a href="/semfee/list/hostel/{{ $h->id }}/Null?sessn_id={{ $sessn->id }}">
                                        {{ $h->Null }}
                                    </a>
                                @else
                                    {{ $h->Null }}
                                @endif
                            </td>
                            <td>
                                @if(auth()->user() && auth()->user()->isFinance())
                                    <a href="/semfee/list/hostel/{{ $h->id }}/Forwarded?sessn_id={{ $sessn->id }}">
                                        {{ $h->Forwarded }}
                                    </a>
                                @else
                                    {{ $h->Forwarded }}
                                @endif
                            </td>
                            <td>
                                @if(auth()->user() && auth()->user()->isFinance())
                                    <a href="/semfee/list/hostel/{{ $h->id }}/Sent?sessn_id={{ $sessn->id }}">
                                        {{ $h->Sent }}
                                    </a>
                                @else
                                    {{ $h->Sent }}
                                @endif
                            </td>
                            <td>
                                @if(auth()->user() && auth()->user()->isFinance())
                                    <a href="/semfee/list/hostel/{{ $h->id }}/Paid?sessn_id={{ $sessn->id }}">
                                        {{ $h->Paid }}
                                    </a>
                                @else
                                    {{ $h->Paid }}
                                @endif
                            </td>
                            <td>
                                @if(auth()->user() && auth()->user()->isFinance())
                                    <a href="/semfee/list/hostel/{{ $h->id }}/Cancelled?sessn_id={{ $sessn->id }}">
                                        {{ $h->Cancelled }}
                                    </a>
                                @else
                                    {{ $h->Cancelled }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </x-block>
    </x-container>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            }
        });

        $("select[name='sessn_id']").change(function(){
            location.replace('/semfee?sessn_id=' + $(this).val());
            // var currentUrl = window.location.href;
            // alert(currentUrl + '?ses');
        });

    });
</script>
</x-layout>
