<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Details of Feedback Criteria for {{ $feedback_criteria->feedback_master->title }}
                <p>
                    <a class="btn btn-primary btn-sm"
                        href="/feedbackMaster/{{ $feedback_criteria->feedback_master->id }}/criteria/">Back</a>
                </p>
            </x-slot>
            <div>
                <table class="table">
                    <tr>
                        <th>Name of Criteria</th>
                        <th>{{ $feedback_criteria->criteria }}</th>
                    </tr>
                    <tr>
                        <th>Type of Criteria</th>
                        <th>{{ $feedback_criteria->type }}</th>
                    </tr>
                </table>
                @if ($feedback_criteria->type == 'Multiple choice')
                    <table class="table">
                        <?php $sl = 1; ?>
                        @foreach ($feedback_criteria->feedback_options as $fo)
                            <tr>
                                <td>{{ $fo->serial }}</td>
                                <td><a href="/feedbackOption/{{ $fo->id }}">{{ $fo->option }}</a></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-secondary"
                                            href="/feedbackOption/{{ $fo->id }}/edit">Edit</a>
                                        <button class="btn btn-danger btn-delete"
                                            value="{{ $fo->id }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('delete')
                    </form>

                    <form method="post" action="/feedbackCriteria/{{ $feedback_criteria->id }}/option">
                        @csrf
                        <input type="hidden" name="feedback_criteria_id" value="{{ $feedback_criteria->id }}">

                        <div class="pt-2 form-group row">
                            <div class="col-md-3">
                                <label for="serial">Serial</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="serial" value="{{ old('serial') }}">
                                @error('serial')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="pt-2 form-group row">
                            <div class="col-md-3">
                                <label for="option">Option</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="option"
                                    value="{{ old('option', $feedback_criteria->option) }}">
                                @error('option')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="pt-2 form-group row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-4">
                                <x-button type="submit">Submit</x-button>
                            </div>
                        </div>
                    </form>
                @endif
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
                    $("form#delete-form").attr('action', '/feedbackOption/' + $(this).val());
                    $("form#delete-form").submit();
                }
            });
        })
    </script>
</x-layout>
