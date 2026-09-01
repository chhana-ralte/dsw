<x-att-layout>
    <x-block>
        <x-slot name="heading">
            Attendance details for {{ $attmaster->subject_code }}: {{ $attmaster->subject_name }}
            <p>
                <a class="btn btn-secondary btn-sm" href="/att">Back</a>
            </p>
        </x-slot>
        
        <a href="/att/attmaster/{{ $attmaster->id }}/take">Take attendance</a>
    </x-block>
    
</x-att-layout>
