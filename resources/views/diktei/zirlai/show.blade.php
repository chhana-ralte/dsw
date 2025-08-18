<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Name of student : {{ $zirlai->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/diktei/course/{{ $zirlai->course_id }}">Back</a>
                </p>
            </x-slot>

        </x-block>
        @if($zirlai->dikteis->count() > 0)
            <x-block>
                <x-slot name="heading">
                    List of Options
                </x-slot>

                <div style="width: 100%; overflow-x:auto">

                    <table class="table">
                        <tr>
                            <th>Option sl.</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Department</th>
                        </tr>
                        @foreach($dikteis as $dt)
                            <tr>
                                <td>{{ $dt->serial }}</td>
                                <td>{{ $dt->subject->code }}</td>
                                <td>{{ $dt->subject->name }}</td>
                                <td>{{ $dt->subject->course->department->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <form id="frmClear" method="post" action="/diktei/clearOptions">
                        @csrf
                        <input type="hidden" name="zirlai_id" value="{{ $zirlai->id }}">
                        <button type="button" class="btn btn-primary btn-clear">Clear submission</button>
                    </form>
                </div>
            </x-block>
        @else
            <x-block>
                <x-slot name="heading">
                    Options not submitted yet
                </x-slot>
            </x-block>
        @endif


    </x-container>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-clear").click(function(){
                confirm("Are you sure you want to clear the submission?"){
                    $("form#frmClear").submit();
                }
            });
        });
    </script>
</x-diktei>
