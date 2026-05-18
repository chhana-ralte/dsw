<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Testing index
                <p>
                    <a class="btn btn-primary btn-sm" href="/testing/create">Create</a>
                </p>
            </x-slot>
            @if(count($tests) > 0)
                <div style="width: 100%, overflow-x: auto">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>num</th>
                            <th>date</th>
                            <th>str</th>
                            <th>txt</th>
                            <th>Delete</th>
                        </tr>
                        @foreach($tests as $test)
                        <tr>
                            <td>{{ $test->id }}</td>
                            <td><a href="/testing/{{ $test->id }}">{{ $test->num }}</a></td>
                            <td>{{ $test->dt }}</td>
                            <td>{{ $test->str }}</td>
                            <td>{{ $test->txt }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-delete" value="{{ $test->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        <form id="frmDelete" method="post" action="/testing">
                            @csrf
                            @method("delete")
                            <input type="hidden" name="test_id" value="100">
                        </form>
                    </table>
                </div>
            @endif









        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $(".btn-delete").click(function(){
                if(confirm("Are you sure you want to delete?")){
                    $("#frmDelete").attr('action', '/testing/' + $(this).val());
                    $("#frmDelete").submit();
                }
            });

        });
    </script>
</x-layout>
