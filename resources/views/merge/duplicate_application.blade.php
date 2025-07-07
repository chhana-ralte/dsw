<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                Duplication Existing Allotment and Application
                <p>
                    <a href="/merge" class="btn btn-secondary btn-sm">
                        Back
                    </a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form name="frm-submit" method="post" action="/merge/update" onsubmit="return confirm('Are you sure you want to update?')">
                    @csrf
                    <input type="hidden" name="mzuid" value="{{ $student->mzuid }}">
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Existing allotment</th>
                                <th>New Application</th>
                                <th>Selected</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>
                                    <input type="radio" id="name1" name="name" value="{{ $student->person->name }}" checked>
                                    <label for="name1">{{ $student->person->name }}</label>
                                </td>
                                <td>
                                    <input type="radio" id="name2" name="name" value="{{ $application->name }}">
                                    <label for="name2">{{ $application->name }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Father/Guardian</td>
                                <td>
                                    <input type="radio" id=father1 name="father" value="{{ $student->person->father }}" checked>
                                    <label for="father1">{{ $student->person->father }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=father2 name="father" value="{{ $application->father }}">
                                    <label for="father2">{{ $application->father }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>State</td>
                                <td>
                                    <input type="radio" id=state1 name="state" value="{{ $student->person->state }}" checked>
                                    <label for="state1">{{ $student->person->state }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=state2 name="state" value="{{ $application->state }}">
                                    <label for="state2">{{ $application->state }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Mobile</td>
                                <td>
                                    <input type="radio" id=mobile1 name="mobile" value="{{ $student->person->mobile }}" checked>
                                    <label for="mobile1">{{ $student->person->mobile }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=mobile2 name="mobile" value="{{ $application->mobile }}">
                                    <label for="mobile2">{{ $application->mobile }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td>
                                    <input type="radio" id=email1 name="email" value="{{ $student->person->email }}" checked>
                                    <label for="email1">{{ $student->person->email }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=email2 name="email" value="{{ $application->email }}">
                                    <label for="email2">{{ $application->email }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Date of birth</td>
                                <td>
                                    <input type="radio" id=dob1 name="dob" value="{{ $student->person->dob }}" checked>
                                    <label for="dob1">{{ $student->person->dob }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=dob2 name="dob" value="{{ $application->dob }}">
                                    <label for="dob2">{{ $application->dob }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Gender</td>
                                <td>
                                    <input type="radio" id=gender1 name="gender" value="{{ $student->person->gender }}" checked>
                                    <label for="gender1">{{ $student->person->gender }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=gender2 name="gender" value="{{ $application->gender }}">
                                    <label for="gender2">{{ $application->gender }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Address</td>
                                <td>
                                    <input type="radio" id=address1 name="address" value="{{ $student->person->address }}" checked>
                                    <label for="address1">{{ $student->person->address }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=address2 name="address" value="{{ $application->address }}">
                                    <label for="address2">{{ $application->address }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Roll number</td>
                                <td>
                                    <input type="radio" id=rollno1 name="rollno" value="{{ $student->rollno }}" checked>
                                    <label for="rollno1">{{ $student->rollno }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=rollno2 name="rollno" value="{{ $application->rollno }}">
                                    <label for="rollno2">{{ $application->rollno }}</label>
                                </td>
                            </tr>

                            <tr>
                                <td>Department</td>
                                <td>
                                    <input type="radio" id=department1 name="department" value="{{ $student->department }}" checked>
                                    <label for="department1">{{ $student->department }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=department2 name="department" value="{{ $application->department }}">
                                    <label for="department2">{{ $application->department }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>Course</td>
                                <td>
                                    <input type="radio" id=course1 name="course" value="{{ $student->course }}" checked>
                                    <label for="course1">{{ $student->course }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=course2 name="course" value="{{ $application->course }}">
                                    <label for="course2">{{ $application->course }}</label>
                                </td>
                            </tr>



                            <tr>
                                <td>Photo</td>
                                <td>
                                    <input type="radio" id=photo1 name="photo" value="{{ $student->person->photo }}" checked>
                                    <label for="photo1">{{ $student->person->photo }}</label>
                                </td>
                                <td>
                                    <input type="radio" id=photo2 name="photo" value="{{ $application->photo }}">
                                    <label for="photo2">{{ $application->photo }}</label>
                                </td>
                            </tr>
                            <tr>


                                <td rowspan=7><img width="200px" src="{{ $student->person->photo }}" alt=""
                                srcset="">
                                </td>

                                <td rowspan=7><img width="200px" src="{{ $application->photo }}" alt=""
                                srcset="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </form>
            </div>
        </x-block>
    </x-container>
{{-- Modal for duplicate requirement --}}

<div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duplicateModalLabel">Possible duplicates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="duplicate" class="col-form-label">Duplicates from new application</label>
                        <div class="col-md-12" style="width:100%;overfloy-x:auto" id="app">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>MZU ID</th>
                                    <th>Course - Department</th>
                                </tr>
                                <tbody id="app-body">
                                </tbody>
                            </table>
                        </div>
                        {{-- <textarea class="form-control" id="duplicate" name="duplicate"></textarea> --}}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal for duplicate requirement --}}
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
               headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               }
            });


        });
    </script>
</x-layout>
