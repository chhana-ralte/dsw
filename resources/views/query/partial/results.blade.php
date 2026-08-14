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