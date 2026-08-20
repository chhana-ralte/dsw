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
                <li>Only admitted students of Mizoram University will be entertained.</li>
                <li>Preference shall be given on merit basis, financial condition, distance, programme based and application seniority.</li>
                <li>Seats will be given as per availability.</li>
                <li>Be ready with your basic personal information, student information and photo of proof for disability, BPL/AAY proof etc. to fill up the form.</li>
                <li>Once the form is filled up, you may be allowed to access and edit your application with your MZU ID and your date of birth.</li>
                <li>Your MZU ID is your application ID in the CUET/Samarth portal.</li>
                @if(\App\Models\Application::status() == "open")
                    <li>Click <a href="/application/create">here</a> to apply for hostel admission.</li>
                @endif
                <li>Click <a href="/application/search">here</a> to view and access your application.</li>
                <li><b>The existing boarders need not apply here. Only new applicants should apply through this online application form.</b></li>
            </ul>
        </x-block>

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

        @if(auth()->user() && auth()->user()->isAdmin())

            <x-block class="col-md-6">
                <x-slot name='heading'>
                    Actions
                </x-slot>
                Current status: <span id="status">{{ App\Models\Application::status() }}</span><br>
                Change status to: <button class=" btn btn-primary btn-status" type="button" value="open">Open</button>
                <button class=" btn btn-primary btn-status" type="button" value="closed">Close</button>
            </x-block>
            <x-block class="col-md-6">
                <x-slot name='heading'>
                    Generate notification
                </x-slot>
                <button type="button" class="btn btn-primary btn-generate">Generate Approved applications for notification</button>
            </x-block>
        @endif
        
    </x-container>
    
    
    {{-- Modal for Notification details --}}
    
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="notify-all" method="post" action="/application/notify-all">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileModalLabel">Enter file details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                        @csrf
                        <input type="hidden" id="type" name="type" value="allotment">
                        <div class="mb-3">
                            <label for="no" class="col-form-label">Notification no.:</label>
                            <input type="text" class="form-control" id="no" name="no">
                            @error('no')
                                <small class="text-danger">{{  $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="col-form-label">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject">
                            @error('subject')
                                <small class="text-danger">{{  $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="dt" class="col-form-label">Date:</label>
                            <input type="date" class="form-control" id="dt" name="dt">
                            @error('dt')
                                <small class="text-danger">{{  $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-confirm-generate">Notify all</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- End modal for Notification details --}}

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

            $("button.btn-generate").click(function(){
                $("#fileModal").modal("show");
            });
        });
    </script>
</x-layout>
