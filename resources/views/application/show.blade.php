<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Applications details
                <p>
                    <a href="/application/{{ $application->id }}/edit?mzuid={{ $application->mzuid }}" class="btn btn-secondary btn-sm">Edit</a>
                </p>
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Personal information
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto">
                    <tr>
                        <th>Name</th>
                        <td>{{ $application->name }}</td>
                        <td rowspan=7><img width="200px" src="{{ $application->photo }}" alt=""
                                srcset=""></td>
                    </tr>
                    <tr>
                        <th>Father/Guardian's name</th>
                        <td>{{ $application->father }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $application->mobile }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $application->email }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $application->category }}</td>
                    </tr>
                    <tr>
                        <th>State/UT</th>
                        <td>{{ $application->state }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $application->address }}</td>
                    </tr>
                </table>
            </div>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Students' information
            </x-slot>
            <table class="table table-auto">
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Rollno</td>
                    <td>{{ $application->rollno }}</td>
                </tr>
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Course name</td>
                    <td>{{ $application->course }}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>{{ $application->department }}</td>
                </tr>
                </tr>
                <td>MZU ID</td>
                <td>{{ $application->mzuid }}</td>
                </tr>
            </table>
        </x-block>

        <x-block>
            <x-slot name="heading">
                Application information
            </x-slot>
            <table class="table table-auto">
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Application ID</td>
                    <td>{{ $application->id }}</td>
                </tr>
                <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                    <td>Submission date</td>
                    <td>{{ $application->dt }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $application->status }}</td>
                </tr>
                </tr>
                <td>Whether valid?</td>
                <td>{{ $application->valid ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Decision:
            </x-slot>
            <div>
                <button class="btn btn-danger btn-status" value="Declined">Decline</button>
                <button class="btn btn-success btn-status" value="Approved">Approve</button>
                <button class="btn btn-warning btn-status" value="Pending">Pending</button>
            </div>
            <form type="hidden" action="/application/{{ $application->id }}" method="post" name="frm_submit">
                @csrf
                @method('PUT')
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <input type="hidden" name="status" value="">
            </form>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            $("button.btn-status").click(function() {
                if (confirm("Are you sure to submit?")) {
                    $("input[name='status']").val($(this).val());
                    $("form[name='frm_submit']").submit();
                }
            });
            $("button.btn-approve").click(function() {
                if (confirm("Are you sure you want to approve this application?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).val() + "/accept",
                        success: function(data, status) {
                            alert("Application accepted successfully.");
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Error accepting application: " + xhr.responseText);
                        }
                    });
                }
            });
            $("button.btn-approve").click(function() {
                if (confirm("Are you sure you want to approve this application?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).val() + "/accept",
                        success: function(data, status) {
                            alert("Application accepted successfully.");
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Error accepting application: " + xhr.responseText);
                        }
                    });
                }
            });

        });
    </script>
</x-layout>
