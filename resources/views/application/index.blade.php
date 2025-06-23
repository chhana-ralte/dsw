<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Application for Hostel.
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Links
            </x-slot>
            <p>Click <a href="/application/create">here</a> to apply for hostel admission.</p>
            <p>Click <a href="/application/list">here</a> to view the applications.</p>
            <p>Click <a href="/application/search">here</a> to check the application status.</p>
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
