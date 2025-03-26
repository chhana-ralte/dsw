<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Remark(s) about {{ $person->name }}
                <p>
                    <a href="{{ $back_link }}" class="btn btn-secondary btn-sm">Back</a>
                    <a href="/person/{{ $person->id }}/person_remark/create" class="btn btn-primary btn-sm">Add remark</a>
                </p>
            </x-slot>                
        </x-block>
        @if(count($person_remarks) > 0)
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
                            @endforeach
                        @endif
                        </td>
                        <td style="   z-index: 2 !important">
                            <div class="dropdown" style="">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    ...
                                </a>
                                <ul class="dropdown-menu" style="z-index: 200">
                                    <li><a class="dropdown-item"
                                            href="/person_remark/{{ $pr->id }}/person_remark_detail/create">Add detail</a></li>
                                    <li><button class="dropdown-item" type="submit" form="delete_form">Delete remark</button></li>
                                    <form method="post" id="delete_form" action="/person_remark/{{ $pr->id }}" onsubmit="return confirm('Are you sure you want to delete the remark?')">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </x-block>
        @else
            <x-block>             
                <x-slot name="heading">
                    No remark available
                </x-slot>  
            </x-block>
        @endif
    </x-container>
</x-layout>
