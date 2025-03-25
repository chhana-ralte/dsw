<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Search
            </x-slot>
        </x-block>

        <x-block>
            <form method="get" action="/search">
                <div class="form-group row">
                    <div class="col col-md-5">
                        <input class="form-control" type="text" name="str" value="{{ $str }}">
                    </div>
                    <div class="col col-md-3">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </x-block>

        @if (count($persons) > 0)
            <x-block>
                <x-slot name="heading">
                    Persons
                </x-slot>
                <div style="width: 100%; overflow-x:auto">
                    <table class="table table-auto">
                        <tr>
                            <th>Name</th>
                            <th>Other info</th>
                        </tr>
                        @foreach($persons as $p)
                            <tr>
                                <td>
                                    @if($p->allot_hostel())
                                        <a href="/allot_hostel/{{ $p->allot_hostel()->id }}?back_link=/search?str={{$str}}">{{ $p->name }}</a>
                                    @else
                                        {{ $p->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($p->student())
                                        dept : {{ $p->student()->department }},
                                        course : {{ $p->student()->course }},
                                    @endif
                                    @if(count($p->allot_hostels)>0)
                                        (
                                        @foreach($p->allot_hostels as $ah)
                                            hostel : {{ $ah->hostel->name }},
                                            stay : {{ $ah->valid?'Yes':'No' }},
                                        @endforeach
                                        ),
                                    @endif
                                    @if($p->other())
                                        {{ $p->other()->remark }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </x-block>
        @endif

        

    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            
        });
    </script>
</x-layout>
