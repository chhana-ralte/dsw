<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Interdisciplinary Course Selection portal
            </x-slot>

        </x-block>
        <x-block>
            Please read the followings carefully before submission:
            <ul>
                <li>Make sure you have valid MZU ID number with the format <b>MZU0000xxxx</b> </li>
                <li>Once entered, you may click 'proceed' and select the maximum of 5 courses, in order of your
                    preference.</li>
                <li>Click <a href='/diktei/entry'>here</a> to begin.</li>
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
</x-diktei>
