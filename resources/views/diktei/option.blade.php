<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Interdisciplinary Course Selection portal
            </x-slot>

        </x-block>

        @if ($status == 'submitted')
            <x-block>
                <span class="text-danger">MZU ID: {{ $zirlai->mzuid }}, Roll no.: {{ $zirlai->rollno }} with name
                    {{ $zirlai->name }} submitted the
                    following options.</span>
                <p>
                    <a href="/diktei/entry" class="btn btn-secondary btn-sm">Submit as another student.</a>
                </p>
            </x-block>
            <div>
                <table class="table">
                    <tr>
                        <th>Option sl.</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Department</th>
                    </tr>
                    @foreach ($dikteis as $dt)
                        <tr>
                            <td>{{ $dt->serial }}</td>
                            <td>{{ $dt->subject->code }}</td>
                            <td>{{ $dt->subject->name }}</td>
                            <td>{{ $dt->subject->course->department->name }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @elseif($status == 'success')
            {{-- if not yet submitted --}}
            <x-block>
                <x-slot name="heading">
                    Name: {{ $zirlai->name }} (Fresh submission)
                </x-slot>
                <form id="frmEntry" method="post" action="/diktei/submit">
                    @csrf
                    <input type="hidden" name="zirlai_id" value="{{ $zirlai->id }}">
                    <input type="hidden" name="status" value="fresh">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="pt-2 form-group row" id="sjrow_{{ $i - 1 }}">
                            <div class="col-md-3">
                                <label for="subject[{{ $i - 1 }}]">{{ 'Option: ' . $i }}</label>
                            </div>
                            <div class="col-md-4">
                                <select name="subject[{{ $i - 1 }}]" class="form-control subject-select">
                                    <option value='0' disabled selected>Select Course</option>
                                    @if ($i == 1)
                                        @foreach (App\Models\Subject::where('course_id','<>',$zirlai->course_id)->orderBy('code')->get() as $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->code }}: {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    @endfor


                    <button type="button" class="btn btn-primary btn-submit">Submit</button>
                </form>

            </x-block>
        @else
            {{-- Resubmission required --}}
            <x-block>
                <x-slot name="heading">
                    Name: {{ $zirlai->name }} (Resubmission)
                </x-slot>
                <div>
                    <h3>Submission earlier</h3>
                    <table class="table">
                        <tr>
                            <th>Option sl.</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Department</th>
                        </tr>
                        @foreach ($dikteis as $dt)
                            <tr>
                                <td>{{ $dt->serial }}</td>
                                <td>{{ $dt->subject->code }}</td>
                                <td>{{ $dt->subject->name }}</td>
                                <td>{{ $dt->subject->course->department->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <h3>Please resubmit from the form below</h3>
                <form id="frmEntry" method="post" action="/diktei/submit">
                    @csrf
                    <input type="hidden" name="zirlai_id" value="{{ $zirlai->id }}">
                    <input type="hidden" name="status" value="resubmit">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="pt-2 form-group row" id="sjrow_{{ $i - 1 }}">
                            <div class="col-md-3">
                                <label for="subject[{{ $i - 1 }}]">{{ 'Option: ' . $i }}</label>
                            </div>
                            <div class="col-md-4">
                                <select name="subject[{{ $i - 1 }}]" class="form-control subject-select">
                                    <option value='0' disabled selected>Select Course</option>
                                    @if ($i == 1)
                                        @foreach (App\Models\Subject::orderBy('code')->get() as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ isset(old('subject')[$i - 1]) && old('subject')[$i - 1] > 0 && old('subject')[$i - 1] == $subject->id ? ' selected ' : '' }}>
                                                {{ $subject->code }}: {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    @endfor


                    <button type="button" class="btn btn-primary btn-submit">Submit</button>
                </form>

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

            for (i = 1; i < 5; i++) {
                $("#sjrow_" + i).hide();
            }



            $("select.subject-select").change(function() {
                var name = $(this).attr("name");
                var id = name.substring(8, name.length - 1);
                var next_id = ++id;
                var next_name = "subject[" + next_id + "]";
                if ($(this).val() != "0") {
                    var str = "0";
                    for (i = 0; i < id; i++) {
                        nm = "subject[" + i + "]";
                        str += "," + $("select[name='" + nm + "']").val();
                    }
                    $.ajax({
                        url: "/ajax/diktei/subjects?str=" + str + "&zirlai_id=" + {{ $zirlai->id }},
                        type: "GET",
                        success: function(data, status) {
                            s = "<option value='0'>None</option>"
                            for (i = 0; i < data.length; i++) {
                                s += "<option value='" + data[i].id + "'>" + data[i].code +
                                    ": " + data[i].name + "</option>";
                            }
                            $("select[name='" + next_name + "']").html(s);
                            $("#sjrow_" + next_id).show();
                            for (i = next_id + 1; i < 10; i++) {
                                $("#sjrow_" + i).hide();
                            }
                        },
                        error: function() {
                            alert("error");
                        }
                    });


                } else {
                    for (i = next_id; i < 10; i++) {
                        $("#sjrow_" + i).hide();
                    }
                }
            });

            $("button.btn-submit").click(function() {
                for (i = 0; i < 5; i++) {
                    if ($("select[name='subject[" + i + "]']").val() == 0) {
                        break;
                    }
                }
                if (i == 5) {
                    if (confirm("Are you sure you want to submit?")) {
                        $("form#frmEntry").submit();
                    }
                } else {
                    alert("Select 5 courses.")
                    exit();
                }
                // alert("asdasdas");
            });

        });
    </script>
</x-diktei>
