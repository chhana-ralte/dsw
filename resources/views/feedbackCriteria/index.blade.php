<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback Criteria for {{ $feedback_master->title }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/feedbackMaster/{{ $feedback_master->id }}">Back</a>
                    <a class="btn btn-primary btn-sm"
                        href="/feedbackMaster/{{ $feedback_master->id }}/criteria/create">Create
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
                            <td><a href="/feedbackCriteria/{{ $fc->id }}">{{ $fc->criteria }}</a></td>
                            <td>{{ $fc->type }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-secondary btn-sm"
                                        href="/feedbackCriteria/{{ $fc->id }}/edit">Edit</a>
                                    <button class="btn btn-danger btn-delete btn-sm"
                                        value="{{ $fc->id }}">Delete</button>
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
                    $("form#delete-form").attr('action', '/feedbackCriteria/' + $(this).val());
                    $("form#delete-form").submit();
                }
            });
        })
    </script>
</x-layout>
