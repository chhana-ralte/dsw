<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications summary
                <p>
                    <a href="/application/" class="btn btn-secondary btn-sm">Back</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">

                        {{-- <tr>
                            <th>Total applications</th>
                            <th>{{ $total }}</th>
                        </tr>

                        <tr>
                            <th colspan=2>State</th>
                        </tr>
                        @foreach($states as $st)
                            <tr>
                                <th>{{ $st->name }}</th>
                                <th>{{ $st->cnt }}</th>
                            </tr>
                        @endforeach --}}
                    <tr>
                        <th colspan=3 style="text-align: center">Based on Status</th>
                    </tr>
                    @foreach($status as $st)
                        <tr>
                            <th>{{ $st->status }}</th>
                            <th>{{ $st->gender }}</th>
                            <th>{{ $st->cnt }}</th>
                        </tr>
                    @endforeach
                </table>
                <table class="table table-auto table-hover">
                    <tr>
                        <th colspan=2 style="text-align: center">Aizawl Municipal Area?</th>
                    </tr>
                    @foreach($amc as $a)
                        <tr>
                            <th>{{ $a->amc }}</th>
                            <th>{{ $a->cnt }}</th>
                        </tr>
                    @endforeach
                </table>
                <table class="table table-auto table-hover">
                    <tr>
                        <th colspan=2 style="text-align: center">Gender</th>
                    </tr>
                    @foreach($gender as $g)
                        <tr>
                            <th>{{ $g->gender }}</th>
                            <th>{{ $g->cnt }}</th>
                        </tr>
                    @endforeach
                </table>
                <table class="table table-auto table-hover">
                    <tr>
                        <th colspan=2 style="text-align: center">Statewise</th>
                    </tr>
                    @foreach($state as $st)
                        <tr>
                            <th>{{ $st->state }}</th>
                            <th>{{ $st->cnt }}</th>
                        </tr>
                    @endforeach
                </table>
                <table class="table table-auto table-hover">
                    <tr>
                        <th colspan=3 style="text-align: center">Course-wise</th>
                    </tr>
                    @foreach($course as $cr)
                        <tr>
                            <th>{{ $cr->course }}</th>
                            <th>{{ $cr->gender }}</th>
                            <th>{{ $cr->cnt }}</th>
                        </tr>
                    @endforeach


                </table>

            </div>
        </x-block>
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
