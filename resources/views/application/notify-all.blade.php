<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notify all approved applications:
            </x-slot>

            <form id="notify-all" method="post" action="/application/notify-all" onsubmit="return validate()">
                @csrf
                <input type="hidden" id="type" name="type" value="allotment">
                <div>
                    <div class="mb-3">
                        <label for="no" class="col-form-label">Existing Notification no.:</label>
                        <select class="form-control" id="notimaster_id" name="notimaster_id">
                            <option value='' selected disabled>Select Notification</option>
                            <option value='0'>New Notification</option>
                            @foreach($notimasters as $nm)
                                <option value="{{ $nm->id }}">{{ $nm->no }} dated: {{ $nm->dt }}</option>
                            @endforeach
                        </select>
                        @error('notimaster_id')
                            <small class="text-danger">{{  $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 new-noti">
                        <label for="no" class="col-form-label">Notification no.:</label>
                        <input type="text" class="form-control" id="no" name="no">
                        @error('no')
                            <small class="text-danger">{{  $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 new-noti">
                        <label for="subject" class="col-form-label">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                        @error('subject')
                            <small class="text-danger">{{  $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 new-noti">
                        <label for="dt" class="col-form-label">Date:</label>
                        <input type="date" class="form-control" id="dt" name="dt">
                        @error('dt')
                            <small class="text-danger">{{  $message }}</small>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-confirm-generate">Notify for selected Hostel(s)</button>
                    </div>
                </div>
                <div>
                    Select the hostel(s) to be notified
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Hostel</th>
                        </tr>
                        @foreach($hostels as $ht)
                        <tr>
                            <td><input name="hostel_ids[]" type="checkbox" value="{{ $ht->id }}"></td>
                            <td>{{ $ht->name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </form>
        </x-block>
    </x-container>
    
    <script>
        function validate(){
            // alert("asdasdasd");
        //    alert($("input[name='hostel_ids[]']:checked").length);
            // alert($(hostel_ids[]).length);
            if(!$(notimaster_id).val()){
                alert("Select the notification type");
                return false;
            }
            else if($(notimaster_id).val() == '0'){
                if(!$(no).val() || !$(dt).val() || !$(subject).val()){
                    alert("Please fill all the forms");
                    return false;
                }
            }
            if($("input[name='hostel_ids[]']:checked").length < 1){
                alert("Select hostel(s)");
                return false;
            }
            return true;
        }
        $(document).ready(function() {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            if($("notimaster_id").val() == '0'){
                $("div.new-noti").show();
            }
            else{
                $("div.new-noti").hide();
            }

            $("select[name='notimaster_id']").change(function(){
                if($(this).val() == '0'){
                    $("div.new-noti").show();
                }
                else{
                    $("div.new-noti").hide();
                }
                // alert($(this).val());
            });
        });
    </script>
</x-layout>
