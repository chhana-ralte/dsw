<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Consolidation
                <p>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-sm" href="/consolidate?type=Course">Course</a>
                        <a class="btn btn-primary btn-sm" href="/consolidate?type=Department">Department</a>
                        <a class="btn btn-primary btn-sm" href="/consolidate?type=Category">Category</a>
                    </div>
                </p>
            </x-slot>
            @if(isset($lists))
                
            <form method="post" action="/consolidate/" class="pt-2">
                <input type="hidden" name="type" value="{{ $type }}">
                @csrf
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <th>{{ $type }}</th>
                        <th>Count</th>
                        <th>Select</th>
                    </tr>
                    <?php $sl = 1 ?>
                    @foreach($lists as $list)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td><a href="/consolidateDetail?type={{ $type }}&str={{ $list->name }}">{{ $list->name }}</td>
                        <td>{{ $list->count }}</td>
                        <td><input type="checkbox" name="list[]" value="{{ $list->name }}"></td>
                    </tr>
                    @endforeach
                </table>
                <div class="form-group row pt-3">
                    <label class="col col-md-4">Select name for the items selected</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col col-md-4">
                        <button type="submit" class="btn btn-primary">Merge</button>
                    </div>
            </form>
            @endif
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