<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                @if($subject)
                    Course : {{ $subject->code }} : {{ $subject->name }} <br>
                    <small>Capacity: {{ $subject->capacity }}</small><br>
                    <small>Department: {{ $subject->course->department->name }}</small>
                @else
                    Select the course to view list of allotted students.
                @endif
            </x-slot>
            <p>
                <a class="btn btn-secondary btn-sm" href="/diktei/course">Back</a>
            </p>
            Select the course:
            <select name="subject_id">
                <option value="0" disabled selected>Select Subject</option>
                @foreach($subjects as $sj)
                    <option value="{{ $sj->id }}" {{ $sj->id==($subject?$subject->id:0)?' selected ':''}}>{{ $sj->code }}: {{ $sj->name }}</option>
                @endforeach
            </select>
            @auth

                <form method="post" id="frmSubmit" action="/diktei/dtallot">
                    @csrf
                    <button type="button" class="btn btn-primary btn-submit">Rerun algorithm</button>
                </form>
            @endauth
        </x-block>
    </x-container>
    @if($subject)
        </x-container>
            <x-block>
                <x-slot name="heading">
                    Courses selected under {{ $subject->code}} : {{ $subject->name }}
                </x-slot>
                @if (count($dtallots) > 0)
                    <div style="width: 100%; overflow-x:auto">

                        <table class="table table-auto">
                            <tr>
                                <th>Sl.</th>
                                <th>MZU ID</th>
                                <th>Roll No.</th>
                                <th>Name</th>
                                <th>Course</th>
                            </tr>
                            <?php $sl=1 ?>
                            @foreach ($dtallots as $dta)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $dta->zirlai->mzuid }}</td>
                                    <td>{{ $dta->zirlai->rollno }}</td>
                                    <td>{{ $dta->zirlai->name }}</td>
                                    <td>{{ $dta->zirlai->course->code }}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </x-block>
        </x-container>
    @endif




    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("select[name='subject_id']").change(function(){
                location.replace("/diktei/dtallot?subject_id=" + $(this).val());
                exit();
            });

            $("button.btn-submit").click(function(){
                if(confirm("Re-running this will erase previous allotments, are you sure?")){
                    $("form#frmSubmit").submit();
                    exit();
                }

            });

        });
    </script>
</x-diktei>
