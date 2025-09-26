<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Standard Operating Procedures
                @can('manages', App\Models\Sop::class)
                <p>
                    <a class="btn btn-primary btn-sm" href="/sop/create">Create new SOP</a>
                </p>
                @endcan
            </x-slot>
            
            <div class="accordion" id="accordionExample">
                @foreach($sops as $sop)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading_{{ $sop->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sop_{{ $sop->id }}" aria-expanded="false" aria-controls="collapseTwo">
                                <strong>{{ $sop->title }}</strong>
                            </button>
                        </h2>
                        <div id="sop_{{ $sop->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {!! substr(strip_tags($sop->content),0,200) !!}
                                @if(strlen(strip_tags($sop->content)) > 200)
                                    ...
                                @endif
                                <p>
                                    <a href="/sop/{{ $sop->id }}">Details</a>
                                </p>
                            </div>
                        </div>
                    </div>
                
                @endforeach
            </div>
            








        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {


        });
    </script>
</x-layout>
