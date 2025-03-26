<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Sessions
                <p>
                    <a href="/sessn/create" class="btn btn-primary btn-sm">Create session</a>
                </p>
            </x-slot>
            @if(count($sessns) > 0)
            <?php $sl = 1 ?>
            <table class="table table-hover table-auto">
                <tr>
                    <th>Sl.</th>
                    <th>Session</th>
                </tr>
                @foreach($sessns as $ssn)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $ssn->name() }}</td>
                    </tr>
                @endforeach
            @endif
        </x-block>
    </x-container>
</x-layout>
