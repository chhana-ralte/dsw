<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Sessions
                <p>
                    <a href="/sessn/create" class="btn btn-primary btn-sm">Create session</a>
                </p>
                <p>
                    <button form="create" class="btn btn-primary btn-sm btn-prev">Create previous</button>
                    <button form="create" class="btn btn-primary btn-sm btn-next">Create next</button>
                </p>
            </x-slot>
            @if(count($sessns) > 0)
                <?php $sl = 1 ?>
                <table class="table table-hover table-auto">
                    <tr>
                        <th>Sl.</th>
                        <th>Session</th>
                        <th>Whether current session?</th>
                    </tr>
                    @foreach($sessns as $ssn)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $ssn->name() }}</td>
                            <td>{{ $ssn->current?"Yes":"No" }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </x-block>
    </x-container>
</x-layout>
