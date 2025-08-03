<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notifications
                <p>
                    <a class="btn btn-primary btn-sm" href="/notification/create">Create new</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Notification No.</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Content</td>
                            <th>Detail</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1 ?>
                        @foreach($notifications as $notif)
                            <tr class="table-white">
                                <td>{{ $sl++ }}</td>
                                <td><a href="/notification/{{ $notif->id }}">{{ $notif->no }}</td>
                                <td>{{ $notif->dt }}</td>
                                <td>{{ $notif->type }}</td>
                                <td>{{ $notif->content }}</td>
                                <td>
                                    @if($notif->type == 'allotment')
                                        <a href="/notification/{{ $notif->id }}/allotment" class="btn btn-primary btn-sm">New Allotments</a>
                                    @elseif($notif->type == 'sem_allot')
                                        <a href="/notification/{{ $notif->id }}/sem_allot" class="btn btn-primary btn-sm">Sem Allotments</a>
                                    @else
                                        Other
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $("meta[name='csrf-token']").attr('content')
        }
    });
});
</script>
</x-layout>
