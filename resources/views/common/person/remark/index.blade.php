<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Remark(s) about {{ $person->name }}
                <p>
                    <a href="{{ $back_link }}" class="btn btn-secondary btn-sm">Back</a>
                    @if($person->valid_allotment()->valid_allot_hostel())
                        @can('update',$person->valid_allotment()->valid_allot_hostel()->hostel)
                            <a href="/person/{{ $person->id }}/person_remark/create" class="btn btn-primary btn-sm">Add remark</a>
                        @endcan
                    @endif
                </p>
            </x-slot>
        </x-block>
    </x-container>
    @if(count($person_remarks) > 0)
        <x-container>
            <x-block>
                <table class="table table-hover table-auto">
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <th>Date of incident</th>
                        <th>Remark</th>
                    </tr>
                    @foreach($person_remarks as $pr)
                    <tr class="bg-white-100 hover:bg-sky-700 text-white-900">
                        <td>{{ $pr->remark_dt }}</td>
                        <td><h4>{{ $pr->remark }}</h4>
                        @if(count($pr->person_remark_details) > 0)
                            @foreach($pr->person_remark_details as $prd)
                                <hr>
                                {{ $prd->detail }}
                                <br>
                                @if(auth()->user()->isWarden() || auth()->user()->isAdmin())
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm" href="/person_remark_detail/{{ $prd->id }}/edit">Edit</a>
                                        <button class="btn btn-danger btn-sm delete_remark_detail" value="{{ $prd->id }}">Delete</button>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        </td>
                        <td style="   z-index: 2 !important">
                            @if(auth()->user()->isWarden() || auth()->user()->isAdmin())
                                <div class="dropdown" style="">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </a>
                                    <ul class="dropdown-menu" style="z-index: 200">
                                        <li><a class="dropdown-item"
                                                href="/person_remark/{{ $pr->id }}/person_remark_detail/create">Add detail</a></li>
                                        <li><button class="dropdown-item delete_remark" type="button" value="{{ $pr->id }}">Delete remark</button></li>
                                        <li><a class="dropdown-item" href="/person_remark/{{ $pr->id }}/edit">Edit remark</button></li>

                                    </ul>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <form method="post" id="delete_person_remark" action="">
                        @csrf
                        @method('delete')
                    </form>
                    <form method="post" id="delete_person_remark_detail" action="">
                        @csrf
                        @method('delete')
                    </form>
                </table>
            </x-block>
        </x-container>
    @else
        <x-container>
            <x-block>
                <x-slot name="heading">
                    No remark available
                </x-slot>
            </x-block>
        </x-container>
    @endif

<script>
$(document).ready(function(){
    $("button.delete_remark").click(function(){
        if(confirm("Are you sure you want to delete the remark?")){
            $("form#delete_person_remark").attr('action',"/person_remark/" + $(this).val());
            $("form#delete_person_remark").submit();
        }
        // alert($(this).val());
    });

    $("button.delete_remark_detail").click(function(){
        if(confirm("Are you sure you want to delete the remark detail?")){
            $("form#delete_person_remark_detail").attr('action',"/person_remark_detail/" + $(this).val());
            $("form#delete_person_remark_detail").submit();
        }
        // alert($(this).val());
    });

});
</script>
</x-layout>
