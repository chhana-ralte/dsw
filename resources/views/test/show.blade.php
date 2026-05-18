<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Testing show
                <p>
                    <a class="btn btn-primary btn-sm" href="/testing/">Index</a>
                    <a class="btn btn-secondary btn-sm" href="/testing/{{ $test->id }}/edit">Edit</a>
                </p>
            </x-slot>
            <div style="width: 100%, overflow-x: auto">
                <table class="table">
                    <tr>
                        <td>ID</td>
                        <th>{{ $test->id }}</th>
                    </tr>
                    <tr>
                        <td>num</td>
                        <th>{{ $test->num }}</th>
                    </tr>
                    <tr>
                        <td>date</td>
                        <th>{{ $test->dt }}</th>
                    </tr>
                    <tr>
                        <td>str</td>
                        <th>{{ $test->str }}</th>
                    </tr>
                    <tr>
                        <td>txt</td>
                        <th>{{ $test->txt }}</th>
                    </tr>
                </table>
            </div>

        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({

            });

        });
    </script>
</x-layout>
