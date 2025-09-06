<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Application for Hostel.
            </x-slot>
        </x-block>
    </x-container>
    <x-container>
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
                @if(\App\Models\Application::status() == "open")
                    <li>Click <a href="/application/create">here</a> to apply for hostel admission.</li>
                @endif
                <li>Click <a href="/application/search">here</a> to view and access your application.</li>
                <li><b>The existing boarders should apply through their login credentials in the portal. Only new applicants should apply through this online application form.</b></li>
            </ul>
        </x-block>
    </x-container>
    <x-container>
        @can('manages',\App\Models\Application::class)

            <x-block class="col-md-6">
                <x-slot name='heading'>
                    Links
                </x-slot>
                <p>Click <a href="/application/list">here</a> to view the applications.</p>
                <p>Click <a href="/duplicate/application">here</a> to view the duplicate applications.</p>
                <p>Click <a href="/application/summary">here</a> to view the application summary.</p>
                <p>Click <a href="/application/summary-hostel">here</a> to view the hostel/department-wise allotment.</p>
                <p>Click <a href="/application/priority-list">here</a> to view the priority list.</p>
            </x-block>

        @endcan

        @if(auth()->user() && (auth()->user()->isDsw() || auth()->user()->isAdmin()))

            <x-block class="col-md-6">
                <x-slot name='heading'>
                    Actions
                </x-slot>
                Current status: <span id="status">{{ App\Models\Application::status() }}</span><br>
                Change status to: <button class=" btn btn-primary btn-status" type="button" value="open">Open</button>
                <button class=" btn btn-primary btn-status" type="button" value="closed">Close</button>
            </x-block>

        @endif
    </x-container>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-status").click(function(){
                $.ajax({
                    url : '/ajax/application/status_update',
                    type : 'post',
                    data : {
                        'status' : $(this).val()
                    },
                    success : function(data,status){
                        $("span#status").text(data);
                        alert("Status updated");
                    },
                    error : function(){
                        alert("Error");
                    }
                })

            });

        });
    </script>
</x-layout>
