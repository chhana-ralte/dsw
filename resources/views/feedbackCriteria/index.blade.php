<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback Criteria for {{ $feedback_master->title }}
                <p>
                    <a class="btn btn-primary" href="/feedbackMaster/{{ $feedback_master->id }}/criteria/create">Create
                        new</a>
                </p>
            </x-slot>
            <div>
                <table class="table">
                    <tr>
                        <th>Sl.</th>
                        <th>Criteria</th>
                        <th>Type</th>
                        <th>Manage</th>
                    </tr>
                    <?php $sl = 1; ?>
                    @foreach ($feedback_criterias as $fc)
                        <tr>
                            <td>{{ $fc->serial }}.</td>
                            <td><a href="/feedbackMaster/{{ $fc->id }}">{{ $fc->criteria }}</a></td>
                            <td>{{ $fc->type }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-secondary" href="/feedbackMaster/{{ $fc->id }}/edit">Edit</a>
                                    <button class="btn btn-danger btn-delete" value="{{ $fc->id }}">Delete</button>
                                </div>
                            </td>
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
