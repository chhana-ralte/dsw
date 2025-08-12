<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Course : {{ $course->name }}
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                List of students
                <p>
                    <button class="btn btn-primary" id="btn-show-add-student">Add student</button>
                </p>
            </x-slot>
            @if(count($course->zirlais) > 0)
                <div style="width: 100%; overflow-x:auto">

                    <table class="table table-auto">
                        <tr>
                            <th>MZU ID</th>
                            <th>Roll No.</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach($course->zirlais as $zl)
                            <tr>
                                <td>{{ $zl->mzuid }}</td>
                                <td>{{ $zl->rollno }}</td>
                                <td>{{ $zl->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm btn-edit-student" value="{{ $zl->id }}">Edit</button>
                                        <button class="btn btn-danger btn-sm btn-delete-student" value="{{ $zl->id }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </x-block>

        <x-block>
            <x-slot name="heading">
                List of courses
                <p>
                    <button class="btn btn-primary" id="btn-show-add-subject">Add course</button>
                </p>
            </x-slot>
            @if(count($course->subjects) > 0)
                <div style="width: 100%; overflow-x:auto">

                    <table class="table table-auto">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        @foreach($course->subjects as $sj)
                            <tr>
                                <td>{{ $sj->code }}</td>
                                <td>{{ $sj->name }}</td>
                                <td>{{ $sj->type }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm btn-edit-subject" value="{{ $sj->id }}">Edit</button>
                                        <button class="btn btn-danger btn-sm btn-delete-subject" value="{{ $sj->id }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </x-block>

    </x-container>

    {{-- Modal for add student --}}
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmZirlai">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="zirlai_id">

                        <div class="mb-3">
                            <label for="mzuid" class="col-form-label">MZU ID</label>
                            <input class="form-control" name="mzuid">
                        </div>

                        <div class="mb-3">
                            <label for="rollno" class="col-form-label">Roll no.</label>
                            <input class="form-control" name="rollno">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name</label>
                            <input class="form-control" name="name">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-add-student">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for add student --}}

    {{-- Modal for add subject --}}
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmSubject">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="subject_id">

                        <div class="mb-3">
                            <label for="code" class="col-form-label">Subject Code</label>
                            <input class="form-control" name="code">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name of Subject</label>
                            <input class="form-control" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="type" class="col-form-label">Type</label>
                            <input class="form-control" name="type" value="IMJ">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-add-subject">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for add subject --}}


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button#btn-show-add-subject").click(function() {
                $("form#frmSubject input[name='code']").val("");
                $("form#frmSubject input[name='name']").val("");
                $("form#frmSubject input[name='subject_id']").val(0);
                $("div#addSubjectModal").modal("show");
                $("div#addSubjectModal").modal("show");
            });

            $("button.btn-edit-subject").click(function(){
                $.ajax({
                    url : '/ajax/subject/' + $(this).val() + '/getSubject',
                    type : 'get',
                    success : function(data, status){
                        $("form#frmSubject input[name='code']").val(data.code);
                        $("form#frmSubject input[name='name']").val(data.name);
                        $("form#frmSubject input[name='type']").val(data.type);
                        $("form#frmSubject input[name='subject_id']").val(data.id);
                        $("div#addSubjectModal").modal("show");

                    },
                    error : function(){
                        alert("Error");
                    },
                });

            });

            $("button.btn-add-subject").click(function(){
                $.ajax({
                    url : '/ajax/course/' + $("input[name='course_id']").val() + '/addSubject',
                    type : 'post',
                    data : {
                        code : $("form#frmSubject input[name='code']").val(),
                        name : $("form#frmSubject input[name='name']").val(),
                        type : $("form#frmSubject input[name='type']").val(),
                        course_id : $("form#frmSubject input[name='course_id']").val(),
                        subject_id : $("form#frmSubject input[name='subject_id']").val(),
                    },
                    success : function(data, status){
                        location.reload();
                    },
                    error : function(){
                        alert('error');
                    }
                });
            });
            $("button.btn-delete-subject").click(function(){
                if (confirm("Are you sure you want to delete this subject?")) {
                    $.ajax({
                        url : '/ajax/subject/' + $(this).val() + '/delete',
                        type : 'post',
                        success : function(){
                            location.reload();
                        },
                        error : function(){
                            alert("Error");
                        },
                    });
                }
            });

            $("button#btn-show-add-student").click(function() {
                $("form#frmZirlai input[name='mzuid']").val("");
                $("form#frmZirlai input[name='rollno']").val("");
                $("form#frmZirlai input[name='name']").val("");
                $("form#frmZirlai input[name='zirlai_id']").val(0);
                $("div#addStudentModal").modal("show");
                $("div#addStudentModal").modal("show");
            });

            $("button.btn-edit-student").click(function(){
                $.ajax({
                    url : '/ajax/zirlai/' + $(this).val() + '/getZirlai',
                    type : 'get',
                    success : function(data, status){
                        $("form#frmZirlai input[name='mzuid']").val(data.mzuid);
                        $("form#frmZirlai input[name='rollno']").val(data.rollno);
                        $("form#frmZirlai input[name='name']").val(data.name);
                        $("form#frmZirlai input[name='zirlai_id']").val(data.id);
                        $("div#addStudentModal").modal("show");

                    },
                    error : function(){
                        alert("Error");
                    },
                });

            });
            $("button.btn-add-student").click(function(){
                $.ajax({
                    url : '/ajax/course/' + $("input[name='course_id']").val() + '/addStudent',
                    type : 'post',
                    data : {
                        name : $("form#frmZirlai input[name='name']").val(),
                        rollno : $("form#frmZirlai input[name='rollno']").val(),
                        mzuid : $("form#frmZirlai input[name='mzuid']").val(),
                        course_id : $("form#frmZirlai input[name='course_id']").val(),
                        zirlai_id : $("form#frmZirlai input[name='zirlai_id']").val(),
                    },
                    success : function(data, status){
                        location.reload();
                    },
                    error : function(){
                        alert('error');
                    }
                });
            });

            $("button.btn-delete-student").click(function(){
                if (confirm("Are you sure you want to delete this student?")) {
                    $.ajax({
                        url : '/ajax/zirlai/' + $(this).val() + '/delete',
                        type : 'post',
                        success : function(){
                            location.reload();
                        },
                        error : function(){
                            alert("Error");
                        },
                    });
                }
            });


            // $("button.btn-edit-student").click(function(){
            //     $.ajax({
            //         url : '/ajax/course/' + $("input[name='course_id']").val() + '/addStudent',
            //         type : 'post',
            //         data : {
            //             zirlai_id : $(this).val(),
            //             name : $("input[name='name']").val(),
            //             rollno : $("input[name='rollno']").val(),
            //             course_id : $("input[name='course_id']").val(),
            //             type : 'edit'
            //         },
            //         success : function(data, status){
            //             alert(data);
            //         },
            //         error : function(){
            //             alert('error');
            //         }
            //     });
            // });

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


        });
    </script>
</x-diktei>
