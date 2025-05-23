<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Editing Feedback criteria for {{ $feedback_criteria->feedback_master->title }}
                <p>
                    <a class="btn btn-secondary btn-sm"
                        href="/feedbackMaster/{{ $feedback_criteria->feedback_master->id }}">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/feedbackCriteria/{{ $feedback_criteria->id }}" class="pt-2">
                @csrf
                @method('PUT')
                <input type="hidden" name="feedback_criteria_id" value="{{ $feedback_criteria->id }}">
                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="criteria">Serial</label>
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" name="serial"
                            value="{{ old('serial', $feedback_criteria->serial) }}" required>
                        @error('serial')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="criteria">Criteria</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="criteria"
                            value="{{ old('criteria', $feedback_criteria->criteria) }}" required>
                        @error('criteria')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="type">Feedback type</label>
                    </div>
                    <div class="col-md-4">
                        <select type="select" class="form-control" name="type" value="{{ old('type') }}">
                            <option value="Short answer"
                                {{ $feedback_criteria->type == 'Short answer' ? 'selected' : '' }}>Short answer</option>
                            <option value="Rating" {{ $feedback_criteria->type == 'Rating' ? 'selected' : '' }}>Rating
                            </option>
                            <option value="Multiple choice"
                                {{ $feedback_criteria->type == 'Multiple choice' ? 'selected' : '' }}>Multiple choice
                            </option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-4">
                        <x-button type="a"
                            href="/feedbackMaster/{{ $feedback_criteria->feedback_master->id }}/criteria">Cancel</x-button>
                        <x-button type="submit">Update</x-button>
                    </div>
                </div>
            </form>
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

                }
            });
        })
    </script>
</x-layout>
