<x-att-layout>
    <x-block>
        <x-slot name="heading">
            Attendance
        </x-slot>
        <p>
            <a class="btn btn-primary btn-sm" href="/att/attmaster/create">Create subject</a>
        </p>
    </x-block>
    <x-container>
        @foreach($attmasters as $am)
            <x-block class="col col-md-4">
                <x-slot name="heading">
                    {{ $am->subject_code }}: {{ $am->subject_name }}
                </x-slot>
                <p>
                    <a href='/att/attmaster/{{ $am->id }}'>Detail&gt;&gt;</a>
                </p>
                <p>
                    <a href='/att/course/{{ $am->course_id }}/sessn/{{ App\Models\Sessn::current()->id }}/enroll/{{ $am->semester }}'>Course Detail&gt;&gt;</a>
                </p>
                <p>
                    <a class="btn btn-primary" href='/att/attmaster/{{ $am->id }}/take/'>Take</a>
                    <a class="btn btn-primary" href='/att/attmaster/{{ $am->id }}/show/'>Show</a>
                </p>
            </x-block>
        @endforeach
    </x-container>
</x-att-layout>
