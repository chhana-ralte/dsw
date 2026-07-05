<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Request for change of hostel in {{ $hostel->name }}
            </x-slot>
        </x-block>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Inbound requests
            </x-slot>
            @if(count($inbound_reqs) > 0)
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
                        @foreach($inbound_reqs as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->allot_hostel->allotment->person->name }}</td>
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
                No inbound hostel change request.
            @endif
        </x-block>
<x-block class="col-md-10">
            <x-slot name="heading">
                Outbound requests
            </x-slot>
            @if(count($outbound_reqs) > 0)
                <div style="width: 100%, overflow-x: auto">
                    <table class="table">
                        <tr>
                            <th>Request ID</th>
                            <th>Change hostel from</th>
                            <th>Change hostel to</th>
                            <th>Date of request</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($outbound_reqs as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
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
                No outbound hostel change request.
            @endif
        </x-block>

    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
               headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               }
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
                            type : 'approve',
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
