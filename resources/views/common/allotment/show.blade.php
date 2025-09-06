<x-layout>


    @if ($allotment->valid_allot_hostel() && $allotment->start_sessn_id != App\Models\Sessn::current()->id && $allotment->confirmed == 1)
        <x-container>
            <x-block>
                @include('common.allotment.partials.requirement')
            </x-block>
        </x-container>
    @endif
    <x-container>
        <x-block>
            @include('common.allotment.partials.personal')
        </x-block>
    </x-container>


    @if ($allotment->person->student())
        <x-container>
            <x-block>
                @include('common.allotment.partials.student')
            </x-block>
        </x-container>

    @elseif($allotment->person->other())
        <x-container>
            <x-block>
                @include('common.allotment.partials.other')
            </x-block>
        </x-container>

    @else
        @auth
            @can('edit', $allotment)
                <x-container>
                    <x-block>
                        @include('common.allotment.partials.choice')
                    </x-block>
                </x-container>
            @endcan
        @endauth
    @endif
    <x-container>
        <x-block>
            @include('common.allotment.partials.allotment')
        </x-block>
    </x-container>
    <x-container>
        <x-block>
            @include('common.allotment.partials.seat')

        </x-block>
    </x-container>

    @can('manage', $allotment)

        <x-container>
            <x-block>
                @include('common.allotment.partials.user')
            </x-block>
        </x-container>

    @endcan

    @if ($allotment->cancel_seat)

        <x-container>
            <x-block>
                @include('common.allotment.partials.cancel')
            </x-block>
        </x-container>

    @endif

    @if (count($allotment->person->person_remarks) > 0)

        <x-container>
            <x-block>
                @include('common.allotment.partials.remark')
            </x-block>
        </x-container>

    @endif

    @if ($allotment->start_sessn())

        <x-container>
            <x-block>
                @include('common.allotment.partials.admission')
            </x-block>
        </x-container>

    @endif

    @if ($allotment->application)

        <x-container>
            <x-block>
                    @include('common.allotment.partials.application')
                </x-block>
        </x-container>
    @endif


</x-layout>
