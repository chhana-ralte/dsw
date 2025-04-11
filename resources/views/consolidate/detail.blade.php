<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                <x-button type="a" href="/consolidate?type={{ $type }}">Back</x-button>
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
                @if($type == 'Course' || $type == "Department")
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Course</th>
                    </tr>
                    <?php $sl = 1 ?>
                    @foreach($lists as $list)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $list->name }}</td>
                        <td>{{ $list->department }}</td>
                        <td>{{ $list->course }}</td>
                    </tr>
                    @endforeach
                </table>
                @elseif($type == 'Category')
                <table class="table">
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Category</th>
                    </tr>
                    <?php $sl = 1 ?>
                    @foreach($lists as $list)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $list->name }}</td>
                        <td>{{ $list->category }}</td>
                    </tr>
                    @endforeach
                </table>
                @endif
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
