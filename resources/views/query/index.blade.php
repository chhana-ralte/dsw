<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of queries
                <p>
                    <a class="btn btn-primary btn-sm" href="/query/create">Create query</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x: auto">
                <table class="table hover">
                    <tr>
                        <th>ID</th>
                        <th>Query</th>
                    </tr>
                    @foreach($queries as $query)
                    <tr>
                        <td>{{ $query->id }}</td>
                        <td><a href="/query/{{ $query->id }}/edit">{{ $query->title }}</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </x-block>
    </x-container>
</x-layout>
