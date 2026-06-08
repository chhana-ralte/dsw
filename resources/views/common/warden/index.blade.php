<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Incumbency list of Warden of {{ $hostel->name }}
                <p>
                    <a href="/hostel/{{ $hostel->id }}" class="btn btn-secondary btn-sm">Back</a>
                    <a href="/hostel/{{ $hostel->id }}/warden/create" class="btn btn-primary btn-sm">Add new Warden</a>
                </p>
            </x-slot>
            @if($warden)
                <h3>Current Warden</h3>
                <div>
                    {{ $warden->person->name }}<br>
                    {{ $warden->person->mobile }}<br>
                    {{ $warden->person->email }}<br>
                    {{ $warden->from_dt }} to {{ $warden->to_dt }}<br>
                </div>
                @if($warden->person->user())
                    User: <a href="/user/{{ $warden->person->user()->id }}">{{ $warden->person->user()->username }}</a>
                @else
                    {{ __('Not a user') }}
                @endif
            @endif

            @if(count($wardens) > 0)
                <div style="width: 100%; overflow-x: auto">
                    <h3>List of wardens</h3>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Default</th>

                        </tr>

                        @foreach($wardens as $wd)
                            <tr>
                                <td>{{ $wd->person->name }}</td>
                                <td>{{ $wd->from_dt }}</td>
                                <td>{{ $wd->to_dt }}</td>
                                <td>
                                    @if($wd->valid == 1)
                                        {{ __('Current Warden') }}
                                    @else
                                    <button class="btn btn-primary btn-sm default" value="{{ $wd->id }}">
                                        {{ __('Make current Warden') }}
                                    </button>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif

        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("button.btn-remove-user").click(function(){
        // alert($(this).val());
        if(confirm("Are you sure you want to remove the user?")){
            $.ajax({
                type : 'post',
                url : '/xx/warden/removeUser',
                data : {
                    warden_id : $(this).val()
                },
                success : function(data, status){
                    alert(data);
                    location.reload();
                },
                error : function(){
                    alert("Error");
                }
            });
        }
    });

    $("button.default").click(function(){
        if(confirm("Are you sure?")){
            $.ajax({
                method : 'PUT',
                type : 'post',
                url : '/warden/' + $(this).val(),
                data : {
                    hostel_id : {{ $hostel->id }},
                    warden_id : $(this).val(),
                },
                success : function(data, status){
                    alert(data);
                    location.replace("/hostel/{{ $hostel->id }}/warden" );
                },
                error : function(){
                    alert("Error");
                },
            });
        }

    });
});
</script>
</x-layout>
