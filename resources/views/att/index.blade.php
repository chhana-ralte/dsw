<x-appl-layout>
    <x-block>
        <x-slot name="heading">
            Attendance
        </x-slot>

    </x-block>
    <x-container>
        @foreach($attmasters as $am)
            <x-block class="col col-md-4">
                <x-slot name="heading">
                    {{ $am->subject_code }}: {{ $am->subject_name }}
                </x-slot>

            </x-block>
        @endforeach
    </x-container>
</x-appl-layout>
