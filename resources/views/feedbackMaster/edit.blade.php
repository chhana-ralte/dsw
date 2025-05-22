<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create Feedback
                <p>
                    <a class="btn btn-secondary btn-sm" href="/feedbackMaster">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/feedbackMaster/{{ $feedbackMaster->id }}" class="pt-2">
                @csrf
                @method('PUT')

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="title">Feedback title</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="title"  value="{{ old('title',$feedbackMaster->title) }}" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="remark">Feedback remark</label>
                    </div>
                    <div class="col-md-4">
                        <textarea class="form-control" name="remark">{{ old('remark',$feedbackMaster->remark) }}</textarea>
                        @error('remark')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="from_dt">From</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="from_dt"  value="{{ old('from_dt',$feedbackMaster->from_dt) }}">
                        @error('from_dt')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="to_dt">To</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="to_dt"  value="{{ old('to_dt',$feedbackMaster->to_dt) }}">
                        @error('to_dt')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-4">
                        <input type='checkbox' id="open" name="open" {{ old('open',$feedbackMaster->open)?' checked ':'' }}>
                        <label for="open">Open?</label>
                        @error('open')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-4">
                        <x-button type="a" href="/feedbackMaster">Back</x-button>
                        <x-button type="submit">Submit</x-button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("button.btn-delete").click(function(){
        if(confirm('Are you sure you want to delete?')){

        }
    });
})
</script>
</x-layout>
