<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Request for change of hostel
            </x-slot>
            @if(count($reqs) > 0)
                <div style="width: 100%, overflow-x: auto">
                    <table class="table">
                        <tr>
                            <th>Request ID</th>
                            <th>Name</th>
                            <th>Change hostel from</th>
                            <th>Change hostel to</th>
                            <th>Date of request</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($reqs as $r)
                        <tr>
                            <td>
                                <button class="btn btn-link p-0 m-0 align-baseline req-detail" value="{{ $r->id }}">{{ $r->id }}</button>
                            </td>
                            <td>
                                <button class="btn btn-link p-0 m-0 align-baseline detail" value="{{ $r->allot_hostel->allotment->id }}">{{ $r->allot_hostel->allotment->person->name }}</button>
                            </td>
                            <td>{{ $r->from_hostel()->name }}</td>
                            <td>{{ $r->to_hostel()->name }}</td>
                            <td>{{ $r->created_at }}</td>

                            <td>
                                @if($r->recommended1_by == 0)
                                    Pending by current warden
                                @elseif($r->recommended2_by == 0)
                                    Pending by intended warden
                                @elseif($r->approved_by == 0)
                                    Pending at DSW
                                @else
                                    Approved
                                @endif
                            </td>
                            <td>
                                @if($r->recommended1_by == 0 && auth()->user()->isWardenOf($r->from_hostel_id))
                                    <button class="btn btn-primary btn-recommend1" value="{{ $r->id }}">
                                        Recommend
                                    </button>
                                @elseif($r->recommended1_by != 0 && $r->recommended2_by == 0 && auth()->user()->isWardenOf($r->to_hostel_id))
                                    <button class="btn btn-primary btn-recommend2" value="{{ $r->id }}">
                                        Recommend
                                    </button>
                                @elseif($r->recommended1_by != 0 && $r->recommended1_by != 0 && auth()->user()->isDsw())
                                    <button class="btn btn-primary btn-approve" value="{{ $r->id }}">
                                        Approve
                                    </button>
                                @else
                                    No action
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <form id="frmDelete" method="post" action="/testing">
                            @csrf
                            @method("delete")
                            <input type="hidden" name="test_id" value="100">
                        </form>
                    </table>
                </div>
            @else
                No hostel change request.
            @endif










        </x-block>
    </x-container>

    {{-- Modal for personal detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <tr>
                            <td>Name</td>
                            <td class="name"></td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td class="mobile"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td class="email"></td>
                        </tr>
                        <tr>
                            <td>Course</td>
                            <td class="course"></td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td class="department"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for personal detail --}}


    {{-- Modal for req detail --}}
    <div class="modal fade" id="reqModal" tabindex="-1" aria-labelledby="reqModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reqModalLabel">Request detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <table class="table content">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for req detail --}}

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
               headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               }
            });

            $("button.detail").click(function(){
                $.ajax({
                    type : 'get',
                    url : '/ajax/allotment/' + $(this).val() + '/getDetail',
                    success : function(data, status){
                        $("td.name").text(data.name);
                        $("td.mobile").text(data.mobile);
                        $("td.email").text(data.email);
                        $("td.course").text(data.course);
                        $("td.department").text(data.department);
                    },
                    error : function(){
                        alert("Error");
                    }
                });
                $("#detailModal").modal("show");
            });

            $("button.req-detail").click(function(){
                $.ajax({
                    type : 'get',
                    url : '/ajax/req/' + $(this).val() + '/getDetail',
                    success : function(data, status){
                        var str = "<tr><td>Request ID</td><td>" + data.id + "</td></tr>"
                            + "<tr><td>From</td><td>" + data.from_hostel + "</td></tr>"
                            + "<tr><td>To</td><td>" + data.to_hostel + "</td></tr>"
                        $("table.content").html(str);
                        console.log(JSON.stringify(data));

                    },
                    error : function(){
                        alert("Error");
                    }
                })
                $("#reqModal").modal("show");
            });

            $(".btn-delete").click(function(){
                if(confirm("Are you sure you want to delete?")){
                    $("#frmDelete").attr('action', '/testing/' + $(this).val());
                    $("#frmDelete").submit();
                }
            });

            $(".btn-recommend1").click(function(){
                if(confirm("Do you wish to recommend?")){
                    $.ajax({
                        type : 'put',
                        url : '/req/' + $(this).val(),
                        data : {
                            type : 'recommended1',
                        },
                        success :function(data, status){
                            location.reload();
                        },
                        error : function(){
                            alert("Error");
                        }
                    });
                }
            });

            $(".btn-recommend2").click(function(){
                if(confirm("Do you wish to recommend?")){
                    $.ajax({
                        type : 'put',
                        url : '/req/' + $(this).val(),
                        data : {
                            type : 'recommended2',
                        },
                        success :function(data, status){
                            location.reload();
                        },
                        error : function(){
                            alert("Error");
                        }
                    });
                }
            });
            $(".btn-approve").click(function(){
                if(confirm("Do you wish to approve?")){
                    $.ajax({
                        type : 'put',
                        url : '/req/' + $(this).val(),
                        data : {
                            type : 'approved',
                        },
                        success :function(data, status){
                            location.reload();
                        },
                        error : function(){
                            alert("Error");
                        }
                    });
                }
            });

        });
    </script>
</x-layout>
