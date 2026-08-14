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
                        <th>Action</th>
                    </tr>
                    @foreach($queries as $query)
                    <tr>
                        <td>{{ $query->id }}</td>
                        <td><a href="/query/{{ $query->id }}/edit">{{ $query->title }}</a></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" value="{{ $query->id }}">Run</button>
                                <a href="/query/{{ $query->id }}/edit" class="btn btn-sm btn-secondary">Edit</a>
                                <button class="btn btn-sm btn-danger btn-delete" value="{{ $query->id }}">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <form id="delete-form" method="post" action="">
                        @csrf
                        @method('delete')
                    </form>
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

            $(".btn-save-query").click(function(){
                $("#title").val('');
                $("#sql").text($("textarea[name='sql']").val());
                $("#remarkModal").modal("show");
            });
            $(".btn-delete").click(function(){
                if(confirm("Are you sure?")){
                    $("form#delete-form").attr('action','/query/' + $(this).val());
                    $("form#delete-form").submit();
                }
            });
        });
    </script>
</x-layout>
