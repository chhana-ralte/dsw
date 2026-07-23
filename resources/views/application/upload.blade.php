<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Please upload necessary files here
            </x-slot>
            <div style="width:100%; overflow-x: auto">
                <table class="table">
                    <tr>
                        <td>Name of applicant</td>
                        <td>{{ $application->name }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $application->department }}</td>
                    </tr>
                    <tr>
                        <td>Course/ Programme</td>
                        <td>{{ $application->course }}</td>
                    </tr>
                    <tr>
                        <td>MZU ID</td>
                        <td>{{ $application->mzuid }}</td>
                    </tr>
                </table>
                <form method="post" action="/application/{{ $application->id }}/upload" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 form-group row">
                        <label
                            for="photo"
                            class="col-md-5"
                        >Passport size photo/ Selfie</label>
                        <div class="col-md-7">
                            <input
                                type="file"
                                class="form-control"
                                name="photo"
                                value="{{ old('photo') }}"
                                placeholder="Passport size/selfie"
                            >
                            @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if($application->PWD == 1)
                        <div class="mb-3 form-group row">
                            <label
                                for="PWD"
                                class="col-md-5"
                            >Whether Person with disability (PWD)?</label>
                            <div class="col-md-7">
                                <input
                                    type="radio"
                                    name="PWD"
                                    id="PWD-yes"
                                    value="yes"
                                    {{ $application->PWD == "1"?' checked ':''}}
                                ><label for="PWD-yes">Yes</label>
                                <input
                                    type="radio"
                                    name="PWD"
                                    id="PWD-no"
                                    value="no"
                                    {{ $application->PWD == "0"?' checked ':''}}
                                ><label for="PWD-no">No</label>
                                @error('PWD')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-group row" id="PWD">
                            <label
                                for="PWD"
                                class="col-md-5"
                            >Please upload valid document</label>
                            <div class="col-md-7">
                                <input
                                    type="file"
                                    class="form-control"
                                    name="PWD_proof"
                                    value="{{ old('PWD_proof') }}"
                                    placeholder="Proof for PWD"
                                >
                                @error('PWD_proof')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    @if($application->BPL == "BPL" || $application->BPL == "AAY")
                        <div class="mb-3 form-group row">
                            <label
                                for="BPL"
                                class="col-md-5"
                            >Whether belonging to BPL/AAY?</label>
                            <div class="col-md-7">
                                <input
                                    type="radio"
                                    name="BPL"
                                    id="BPL"
                                    value="BPL"
                                    {{ $application->BPL == 'BPL'?' checked ':''}}
                                ><label for="BPL">BPL</label>
                                <input
                                    type="radio"
                                    name="BPL"
                                    id="AAY"
                                    value="AAY"
                                    {{ $application->BPL == "AAY"?' checked ':''}}
                                ><label for="AAY">AAY</label>
                                <input
                                    type="radio"
                                    name="BPL"
                                    id="None"
                                    value="None"
                                    {{ $application->BPL == "None"?' checked ':''}}
                                ><label for="None">None</label>
                                @error('None')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-group row" id="BPL">
                            <label
                                for="BPL_proof"
                                class="col-md-5"
                            >Please upload valid document for BPL/AAY</label>
                            <div class="col-md-7">
                                <input
                                    type="file"
                                    class="form-control"
                                    name="BPL_proof"
                                    value="{{ old('BPL_proof') }}"
                                    placeholder="Proof for BPL/AAY"
                                >
                                @error('BPL_proof')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="mb-3 form-group row">
                        <label
                            for="photo"
                            class="col-md-5"
                        ></label>
                        <div class="col-md-7">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
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

            $("input[name='PWD']").change(function(){
                if($("input[name='PWD']:checked").val() == 'yes'){
                    $("div#PWD").show();
                }
                else{
                    $("div#PWD").hide();
                }
                // alert($("input[name='PWD']").prop('checked'));
            });

            $("input[name='BPL']").change(function(){
                //alert($("input[name='BPL']:checked").val());
                if($("input[name='BPL']:checked").val() == 'None'){
                    $("div#BPL").hide();
                }
                else{
                    $("div#BPL").show();
                }
                // alert($("input[name='PWD']").prop('checked'));
            });

            $("button.btn-status").click(function() {
                alert("asdsadsad");
                if ($(this).val() == 'approve-modal') {
                    $("#hostelModal").modal("show");
                    // $("input[name='status']").val($(this).val());
                    // $("input[name='hostel_id']").val($("select#hostel").val());
                    // $("input[name='roomtype']").val($("select#type").val());
                    // $("form[name='frm_submit']").submit();
                }
                else if ($(this).val() == 'approve-hostel'){
                    if(!$("select#hostel").val()){
                        alert("Select the hostel where student is to be allotted. Or click 'Just Approve' without hostel");
                    }
                    else{
                        $("input[name='status']").val($(this).val());
                        $("input[name='hostel_id']").val($("select#hostel").val());
                        $("input[name='roomtype']").val($("select#type").val());
                        $("form[name='frm_submit']").submit();
                    }
                }
                else {
                    $("input[name='status']").val($(this).val());
                    $("form[name='frm_submit']").submit();
                }
            });

            $("button.btn-approve").click(function() {
                alert($(this).val());
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

            });

            $("button.btn-delete").click(function() {
                if (confirm("Are you sure you want to delete this application?")) {
                    $.ajax({
                        type: "post",
                        url: "/ajax/application/" + $(this).val() + "/delete",
                        success: function(data, status) {
                            alert("Application deleted successfully.");
                            {{-- alert(data.id) --}}
                            location.replace("/application/" + data.id);
                            {{-- location.reload(); --}}
                        },
                        error: function(xhr, status, error) {
                            alert("Error deleting application: " + xhr.responseText);
                        }
                    });
                }
            });

            {{-- $("button.btn-approve").click(function() {
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
            }); --}}
            $("button.btn-save").click(function() {

                $.ajax({
                    type: "post",
                    url: "/ajax/application/" + $("input[name='application_id']").val() + "/remark",
                    data: {
                        remark: $("#remark").val()
                    },
                    success: function(data, status) {
                        {{-- alert("Remark saved successfully."); --}}
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Error saving remark: " + xhr.responseText);
                    }
                });

            });

            $("button.btn-navigate").click(function() {
                $("input[name='navigation']").val($(this).val());
                $("form[name='frm-navigate']").submit();
            });

        });
    </script>
</x-layout>
