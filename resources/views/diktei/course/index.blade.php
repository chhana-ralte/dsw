<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                List of PG Courses
            </x-slot>

            <div style="width: 100%; overflow-x:auto">

                <table class="table table-auto">
                    <tr>
                        <th>Sl.</th>
                        <th>Programme Code</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Students</th>
                        <th>Courses</th>
                    </tr>
                    <?php $sl = 1; ?>
                    @foreach (App\Models\Course::where('type', 'PG')->orderBy('name')->get() as $course)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td><a href="/course/{{ $course->id }}">{{ $course->code }}</a></td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->department->name }}</td>
                            <td>{{ $course->zirlais->count() }}</td>
                            <td>{{ $course->subjects->count() }}</td>
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
