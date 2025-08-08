<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notifications
                @can('manages', App\Models\Notification::class)
                    <p>
                        <a class="btn btn-primary btn-sm" href="/notification/create">Create new</a>
                    </p>
                @endcan
            </x-slot>
            <div style="width: 100%; overflow-x:auto">
                <form method="post" name="frmUpdate" action="/notiMaster/addToNotiMaster">
                    @csrf
                    <input type="hidden" name="noti_master_id" value="">
                    <table class="table table-auto table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" value="all"></th>
                                <th>Sl.</th>
                                <th>Notification No.</th>
                                <th>Type</th>
                                <th>Content</td>
                                <th>Master</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            @foreach ($notifications as $notif)
                                <tr class="table-white">
                                    <td><input type="checkbox" name="notification_ids[]" value="{{ $notif->id }}">
                                    </td>
                                    <td>{{ $sl++ }}</td>
                                    <td><a href="/notification/{{ $notif->id }}">{{ $notif->no }}</td>

                                    <td>{{ $notif->type }}</td>
                                    <td>{{ $notif->content }}</td>
                                    <td>
                                        @if ($notif->notiMaster)
                                            {{ $notif->notiMaster->no }}
                                        @else
                                            <span class="text-danger">Not available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        <button type="button" class="btn btn-primary" name="btn-modal-show">Add to Notification
                            Master</button>
                    </div>
                </form>
            </div>
        </x-block>
    </x-container>
    {{-- Modal for add to file master --}}
    <div class="modal fade" id="notifMasterModal" tabindex="-1" aria-labelledby="notifMasterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifMasterModalLabel">Add to Notification Master</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- <table class="table">
                        <thead>
                            <tr>
                                <th colspan=2>
                                    Move these files to...
                                </th>
                            </tr>
                            <tr>
                                <th>File no</th>
                                <th>Type</th>
                            <tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> --}}


                    <div class="mb-3">
                        <label for="notifMaster" class="col-form-label">notification Master:</label>
                        <select class="form-control" name="notiMaster_id">
                            @foreach (App\Models\NotiMaster::all() as $nm)
                                <option value="{{ $nm->id }}">{{ $nm->no }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal for add to file master --}}
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            $('.table tr').click(function(event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });

            $("button[name='btn-modal-show']").click(function() {
                var nos = 0;
                $("input[name='notification_ids[]']").each(function() {
                    if ($(this).prop('checked')) {
                        nos++;
                    }
                });

                if (nos == 0) {
                    alert("Please select the notification(s)");
                    exit();
                }
                $("div#notifMasterModal").modal("show");
            });

            $("button.btn-save").click(function() {

                if ($("select[name='notiMaster_id']").val() == 0) {
                    alert("Please select the master file");
                    exit();
                }
                $("input[name='noti_master_id']").val($("select[name='notiMaster_id']").val());

                $("form[name='frmUpdate']").submit();

            });
        });
    </script>
</x-layout>
