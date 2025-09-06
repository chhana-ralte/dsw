<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback Master
                @can('manages', App\Models\Feedback::class)
                    <p>
                        <a class="btn btn-primary btn-sm" href="/feedbackMaster/create">Create new</a>
                    </p>
                @endcan
            </x-slot>
            <div>
                <table class="table">
                    <tr>
                        <th>Sl.</th>
                        <th>Title</th>
                        <th>Remark</th>
                        <th>Opened?</th>
                        @can('manages', App\Models\Feedback::class)
                            <th>Manage</th>
                        @endcan
                    </tr>
                    <?php $sl = 1; ?>
                    @foreach ($feedback_masters as $fm)
                        <tr>
                            <td>{{ $sl++ }}.</td>
                            <td><a href="/feedbackMaster/{{ $fm->id }}">{{ $fm->title }}</a></td>
                            <td>{{ $fm->remark }}</td>
                            <td>{{ $fm->open ? 'Opened' : 'Closed' }}</td>
                            @can('manages', App\Models\Feedback::class)
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-secondary" href="/feedbackMaster/{{ $fm->id }}/edit">Edit</a>
                                        <button class="btn btn-danger btn-delete" value="{{ $fm->id }}">Delete</button>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                </table>
            </div>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("button.btn-delete").click(function() {
                if (confirm('Are you sure you want to delete?')) {
                    $("form#delete-form").attr('action', '/feedbackMaster/' + $(this).val());
                    $("form#delete-form").submit();
                }
            });
        })
    </script>
</x-layout>
