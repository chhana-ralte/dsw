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
                            <th>Change hostel to</th>
                            <th>Date of request</th>
                            <th>Status</th>

                        </tr>
                        @foreach($reqs as $r)
                        <tr>
                            <td>{{ $r->id }}</td>

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
                No hostel change request submitted
            @endif
            <a class="btn btn-primary btn-sm" href="/allot_hostel/{{ $allot_hostel->id }}/req/create">Submit request</a>









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

                }
            });

        });
    </script>
</x-layout>
