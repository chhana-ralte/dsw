<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                New query
                <p>
                    <a class="btn btn-secondary btn-sm" href="/query/">Back</a>
                </p>
            </x-slot>
            <div>
                <form method="post" action="/query/exec">
                    @csrf
                    <input type="hidden" name="query_id" value="0">
                    <div class="form-group row mb-3">
                        <label class="col col-md-4">Title</label>
                        <div class="col col-md-8">
                            <input class="form-control" type="text" name='title'>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col col-md-4">SQL</label>
                        <div class="col col-md-8">
                            <textarea class="form-control" name="sql"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col col-md-4">Action</label>
                        <div class="col col-md-8">
                            <button class="btn btn-primary" type="button">Create</button>
                            <button class="btn btn-primary" type="submit">Go</button>
                        </div>
                    </div>
                </form>

            </div>
            @if(isset($results))
                <div style="width: 100%; overflow-x: auto">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                @if(count($results) > 0)
                                    {{-- Extract column names from the first object --}}
                                    @foreach(array_keys(get_object_vars($results[0])) as $column)
                                        <th>{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                                    @endforeach
                                @else
                                    <th>No Data Available</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $row)
                                <tr>
                                    {{-- Loop through every property/column in the current row --}}
                                    @foreach(get_object_vars($row) as $columnName => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </x-block>
    </x-container>
</x-layout>
