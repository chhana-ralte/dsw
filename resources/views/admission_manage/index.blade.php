<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Application form
            </x-slot>
            <div>
                <p>Welcome to the application form. Please fill out the necessary details below.</p>
                <p>Click <a href="{{ route('application.create') }}">Here</a> to Go to Application
                    Form</p>
            </div>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });


        });
    </script>
</x-layout>
