<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Interdisciplinary Course Selection portal
            </x-slot>

        </x-block>
        @if ($status == 'failure')
            <x-block>
                <span class="text-danger">Your MZU ID (Application Form Number) is not found.</span>
                <p>
                    <a href="/diktei/entry" class="btn btn-secondary btn-sm">Enter again</a>
                </p>
            </x-block>
        @else
            <x-block>
                <x-slot name="heading">
                    Name: {{ $zirlai->name }}
                </x-slot>
                <form id="frmEntry" method="post" action="/diktei/submit">
                    @csrf
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


                    <button class="submit-btn btn btn-primary">Submit</button>
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
                        url: "/ajax/diktei/subjects?str=" + str,
                        type: "GET",
                        success: function(data, status) {
                            s = "<option value='0'>None</option>"
                            for (i = 0; i < data.length; i++) {
                                s += "<option value='" + data[i].id + "'>" + data[i].code +
                                    ": " + data[i].title + "</option>";
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

        });
    </script>
</x-diktei>
