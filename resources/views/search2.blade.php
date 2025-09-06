<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Search
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <form method="get" action="/search">
                <div class="form-group row">
                    <div class="col col-md-5">
                        <input class="form-control" type="text" name="str" value="{{ $str }}">
                    </div>
                    <div class="col col-md-3">
                        <select class="form-control" name="hostel">
                            <option value="0">All hostels</option>
                            @foreach(App\Models\Hostel::orderBy('name')->get() as $h)
                            <option value="{{ $h->id }}" {{ $hostel==$h->id?' selected ':'' }}>{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col col-md-3">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
    @if (count($search_results) > 0)
        <x-container>
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
                        @foreach($search_results as $sr)
                            <tr>
                                <td>
                                    @if($sr->allotment)
                                        @can('view',$sr->allotment)
                                            <a href="/allotment/{{ $sr->allotment->id }}?back_link=/search?str={{$str}}">{{ $sr->name }}</a>
                                        @else
                                            {{ $sr->name }}
                                        @endcan
                                    @else
                                        {{ $sr->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($sr->student)
                                        dept : {{ $sr->student->department }},
                                        course : {{ $sr->student->course }},
                                    @endif
                                    @if($sr->allotment && $sr->allotment->valid==1 && count($sr->allotment->allot_hostels)>0)
                                        (
                                        @foreach($sr->allotment->allot_hostels as $ah)
                                            hostel : {{ $ah->hostel->name }},
                                            stay : {{ $ah->valid?'Yes':'No' }},
                                        @endforeach
                                        ),
                                    @endif
                                    @if($sr->person->other())
                                        {{ $sr->person->remark }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </x-block>
        </x-container>
    @endif



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
