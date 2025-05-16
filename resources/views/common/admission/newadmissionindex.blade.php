<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Newly allotted inmates of {{ $hostel->name }} Hall of Residence for the {{ $sessn->name() }} session.
                <p>
                    <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                        href="/hostel/{{ $hostel->id }}">Back to {{ $hostel->name }}</a>
                    @if ($adm_type == 'old')
                        <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                            href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}&adm_type=new">New
                            admissions</a>
                    @else
                        <a class="bg-secondary hover:bg-secondary-dark text-white font-bold py-2 px-4 rounded text-sm"
                            href="/hostel/{{ $hostel->id }}/admission?sessn={{ $sessn->id }}">Existing
                            admissions</a>
                    @endif
                    <input style="font-size:15px" type="text" name="find" />
                </p>
            </x-slot>
            <div class="w-full overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100 text-gray-900">
                        <tr>
                            <th class="px-4 py-2 text-left">Sl.</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Department</th>
                            <td class="px-4 py-2">Action</td>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-black">
                        <?php $sl = 1; ?>
                        @foreach ($new_allotments as $allotment)
                            <tr class="bg-white row_{{ $allotment->id }}">
                                <td class="px-4 py-2">{{ $sl++ }}</td>
                                <td class="px-4 py-2 name">{{ $allotment->person->name }}</td>
                                @if ($allotment->person->student())
                                    <td class="px-4 py-2">{{ $allotment->person->student()->course }}</td>
                                    <td class="px-4 py-2">{{ $allotment->person->student()->department }}</td>
                                @elseif($allotment->person->other())
                                    <td colspan="2" class="px-4 py-2"><b>Not a student
                                            ({{ $allotment->person->other()->remark }})
                                        </b>
                                    </td>
                                @else
                                    <td colspan="2" class="px-4 py-2"><b>No info</b></td>
                                @endif
                                <td class="px-4 py-2">
                                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        href="/allotment/{{ $allotment->id }}/admission/create?sessn_id={{ $sessn->id }}">Options</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
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
            $("button.btn-confirm").click(function() {
                id = $(this).val();

                $.ajax({
                    url: "/ajax/manage_admission",
                    type: "post",
                    data: {
                        'undo': $("button.btn-confirm[name='admit_" + id + "']").text() == "Undo" ?
                            1 : 0,
                        'sessn_id': {{ $sessn->id }},
                        'allot_hostel_id': $(this).val()
                    },
                    success: function(data, status) {

                        if (data.undo == 1) {
                            $("label#label_" + data.allot_hostel_id).text("Not done");
                            $("button[name='admit_" + data.allot_hostel_id + "']").text(
                                "Confirm");

                        } else {
                            $("label#label_" + data.allot_hostel_id).text("Done");
                            $("button[name='admit_" + data.allot_hostel_id + "']").text("Undo");

                        }
                    },
                    error: function() {
                        alert("Error");
                    }
                });
                // alert($(this).val());
            });

            $("input[name='find']").on("keyup", function() {
                var pattern = $(this).val();

                $("table tr").each(function(index) {
                    if (index != 0) {
                        $row = $(this);
                        var text = $row.find("td.name").text().toLowerCase().trim();
                        if (text.match(pattern)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }
                });
            });
        });
    </script>
</x-layout>
