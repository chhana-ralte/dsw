<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Partial / Incomplete submission
            </x-slot>

            <div style="width: 100%; overflow-x:auto">

                <table class="table table-auto">
                    <tr>
                        <th>Sl.</th>
                        <th>Name</th>
                        <th>Rollno</th>
                        <th>MZU ID</th>
                        <th>Programme</th>
                        <th>Options submitted</th>
                        <th>Status</th>
                    </tr>
                    <?php $sl = 1; ?>
                    @foreach ($zirlais as $zl)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td><a href="/zirlai/{{ $zl->id }}">{{ $zl->name }}</a></td>
                            <td>{{ $zl->rollno }}</td>
                            <td>{{ $zl->mzuid }}</td>
                            <td>{{ $zl->code }}</td>
                            <td>{{ $zl->cnt }}</td>
                            <td>
                                @if ($zl->dtallot)
                                    Allotted : {{ $zl->dtallot->subject->code }}
                                @else
                                    <span class="text-warning">Not Allotted</span>
                                @endif

                            </td>
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
</x-diktei>
