<x-layout>
    <x-container>
        <x-block>
            @include('common.allotment.partials.personal')
        </x-block>

        @if ($allotment->person->student())
            <x-block>
                @include('common.allotment.partials.student')
            </x-block>
        @elseif($allotment->person->other())
            <x-block>
                @include('common.allotment.partials.other')
            </x-block>
        @else
            @auth
                @can('edit', $allotment)
                    <x-block>
                        @include('common.allotment.partials.choice')
                    </x-block>
                @endcan
            @endauth
        @endif

        <x-block>
            @include('common.allotment.partials.allotment')
        </x-block>

        <x-block>
            @include('common.allotment.partials.seat')

        </x-block>

        @can('manage',$allotment)
            <x-block>
                @include('common.allotment.partials.user')
            </x-block>
        @endcan

        @if ($allotment->cancel_seat)
            <x-block>
                @include('common.allotment.partials.cancel')
            </x-block>
        @endif

        @if (count($allotment->person->person_remarks) > 0)
            <x-block>
                @include('common.allotment.partials.remark')
            </x-block>
        @endif

        @if($allotment->start_sessn())
            <x-block>
                @include('common.allotment.partials.admission')
            </x-block>
        @endif
    </x-container>
</x-layout>
