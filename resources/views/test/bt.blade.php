<x-layout>
<div class="container">
    <div class="row my-3 justify-content-center">
        <div class="col-md-5 border">
            <h4 class="text-center text-primary">How do you rate the food quality.</h4>
            <p class=" small">asdf asdasd asdas</p>
            Ziak rawh le..
            <textarea id="editor" name="content" rows="10" placeholder="Ziak rawh le...">
                <p></p>
            </textarea>
        </div>
    </div>
    <div class="row my-3 justify-content-center">
        <div class="col-md-5 border">
            <h4 class="text-center text-primary">How do you rate the food quality.</h4>

            <label for="customRange2" class="form-label">Example range</label>
            <div class="input-group">

                <div class="input-group-prepend">
                    <span class="input-group-text">Min</span>
                </div>
                <input type="range" class="form-control" min="1" max="5" id="customRange2">
                <div class="input-group-append">
                    <span class="input-group-text">Max</span>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-status").click(function() {
                if ($(this).val() == 'approve-hostel') {
                    $("input[name='status']").val($(this).val());
                    $("input[name='hostel_id']").val($("select#hostel").val());
                    $("input[name='roomtype']").val($("select#type").val());
                    $("form[name='frm_submit']").submit();
                } else {
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
