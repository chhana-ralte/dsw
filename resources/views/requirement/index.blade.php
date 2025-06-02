<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Kindly select the requirement for next semester
            </x-slot>
        </x-block>
        <div style="width: 100%; overflow-x:auto">
            Instructions:
            <ul>
                <li>Click on the requirement to view details.</li>
                <li>Click on the "Apply" button to submit your application for the selected requirement.</li>
                <li>Ensure all details are filled out correctly before submitting.</li>
                <li>For any issues, contact the administration office.</li>
            </ul>
        </div>
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
