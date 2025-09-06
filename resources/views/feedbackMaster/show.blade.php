<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback for {{ $feedbackMaster->title }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="/feedbackMaster/">Back</a>
                    @can('manages', App\Models\Feedback::class)
                        <a class="btn btn-primary btn-sm" href="/feedbackMaster/{{ $feedbackMaster->id }}/report">Report</a>
                        <a class="btn btn-primary btn-sm"
                            href="/feedbackMaster/{{ $feedbackMaster->id }}/criteria">Criteria</a>
                        <a class="btn btn-primary btn-sm"
                            href="/feedbackMaster/{{ $feedbackMaster->id }}/feedback">Feedback</a>
                    @endcan
                </p>
            </x-slot>
            <div>


                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="title">Feedback title</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="title"
                            value="{{ old('title', $feedbackMaster->title) }}" disabled>
                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="remark">Feedback remark</label>
                    </div>
                    <div class="col-md-4">
                        <textarea class="form-control" name="remark" disabled>{{ old('remark', $feedbackMaster->remark) }}</textarea>

                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="from_dt">From</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="from_dt"
                            value="{{ old('from_dt', $feedbackMaster->from_dt) }}" disabled>

                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                        <label for="to_dt">To</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="to_dt"
                            value="{{ old('to_dt', $feedbackMaster->to_dt) }}" disabled>

                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-4">
                        <input type='checkbox' id="open" name="open"
                            {{ old('open', $feedbackMaster->open) ? ' checked ' : '' }} disabled>
                        <label for="open">Open?</label>
                        @error('open')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-2 form-group row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-4">
                        <x-button type="a" href="/feedbackMaster">Back</x-button>

                    </div>
                </div>
                </form>
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

        })
    </script>
</x-layout>
