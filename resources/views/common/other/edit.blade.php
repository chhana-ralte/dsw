<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Editing other info for: {{ $other->person->name }}
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Details
            </x-slot>
            <form method="post" action="/other/{{ $other->id }}">
                @csrf
                @method('put')
                <input type='hidden' name='back_link' value="{{ $back_link }}">

                <div class="form-group row mb-3">
                    <label for="remark" class="col col-md-3">Remark</label>
                    <div class="col col-md-4">
                        <textarea class="form-control" name="remark">{{ old('remark',$other->remark) }}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <a class="btn btn-secondary" href="{{ $back_link }}">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="update">Update</update>
                    </div>
                </div>
            </form>
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
