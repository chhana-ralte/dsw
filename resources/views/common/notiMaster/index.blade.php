<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notifications
                <p>
                    <a class="btn btn-primary btn-sm" href="/notiMaster/create">Create new</a>
                </p>
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <table class="table table-auto table-hover">
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
                        <?php $sl = 1; ?>
                        @foreach ($noti_masters as $nm)
                            <tr class="table-white">
                                <td>{{ $sl++ }}</td>
                                <td><a href="/notiMaster/{{ $nm->id }}">{{ $nm->no }}</td>
                                <td>{{ $nm->dt }}</td>
                                <td>{{ $nm->type }}</td>
                                <td>{{ $nm->content }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        });
    </script>
</x-layout>
