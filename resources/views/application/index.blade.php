<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Application for Hostel.
            </x-slot>
        </x-block>
        <x-block>
            <x-slot name="heading">
                Required information for applicants:
            </x-slot>
            <ul>
                <li>This portal is for applying accommodation to the halls of residence, Mizoram University.</li>
                <li>Only registered students of Mizoram University will be entertained.</li>
                <li>Preference shall be given on merit basis, performance and distance.</li>
                <li>Seats will be given as per availability.</li>
                <li>Be ready with your basic personal information and student information to fill up the form.</li>
                <li>Once the form is filled up, you may be allowed to access and edit your application with your MZU ID and your date of birth.</li>
                <li>Your MZU ID is your application ID in the CUET/Samarth portal.</li>
                <li>Click <a href="/application/create">here</a> to apply for hostel admission.</li>
                <li>Click <a href="/application/search">here</a> to view and access your application.</li>
                <li><b>The existing boarders should apply through their login credentials in the portal. Only new applicants should apply through this online application form.</b></li>
            </ul>
        </x-block>
        @can('manages',\App\Models\Application::class)
            <x-block>
                <x-slot name='heading'>
                    Links
                </x-slot>
                <p>Click <a href="/application/list">here</a> to view the applications.</p>
                <p>Click <a href="/duplicate/application">here</a> to view the duplicate applications.</p>
            </x-block>
        @endcan
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
