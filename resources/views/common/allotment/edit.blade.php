<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Edit the allotment details for {{ $allotment->person->name }}
                <p>
                    <a href="/allotment/{{ $allotment-> id }}" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/allotment/{{ $allotment-> id }}">
                @csrf
                @method('put')
                <input type="hidden" name="back_link" value="{{ $back_link }}">
                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Name</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ old('name',$allotment->person->name) }}" disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Allotment order</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="no" value="{{ $allotment->notification->no }} dated {{$allotment->notification->dt}}" disabled>
                    </div>
                </div>

                

                <div class="form-group row mb-3">
                    <label for="hostel" class="col col-md-3">Hostel*</label>
                    <div class="col col-md-4">
                        <select name='hostel' class='form-control' required
                            @cannot('manage',$allotment)
                                disabled
                            @endcan
                        >
                            <option value=0 >Select Hostel</option>
                            @foreach(\App\Models\Hostel::orderBy('name')->get() as $h)
                                <option value='{{ $h->id }}' {{ $h->id==$allotment->hostel_id?" selected ":""}}>{{ $h->name }} ({{ $h->gender }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="start_sessn" class="col col-md-3">Starting session</label>
                    <div class="col col-md-4">
                        <select name='start_sessn' class='form-control' required
                            @cannot('manage_self',$allotment)
                                disabled
                            @endcan
                        >
                            <option value=0 >Select starting session</option>
                            @foreach(\App\Models\Sessn::orderBy('id')->get() as $ssn)
                                <option value='{{ $ssn->id }}' {{ $ssn->id==$allotment->start_sessn_id?" selected ":""}}>{{ $ssn->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="end_sessn" class="col col-md-3">Expected ending session</label>
                    <div class="col col-md-4">
                        <select name='end_sessn' class='form-control' required
                            @cannot('manage_self',$allotment)
                                disabled
                            @endcan
                        >
                            <option value=0 >Select ending session</option>
                            @foreach(\App\Models\Sessn::orderBy('id')->get() as $ssn)
                                <option value='{{ $ssn->id }}' {{ $ssn->id==$allotment->end_sessn_id?" selected ":""}}>{{ $ssn->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                @can('manage',$allotment)

                    <div class="form-group row mb-3">
                        <label for="from_dt" class="col col-md-3">Allotment from*</label>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="from_dt" value="{{ old('from_dt',$allotment->from_dt) }}"
                            @cannot('manage',$allotment)
                                readonly
                            @endcan
                            required>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="to_dt" class="col col-md-3">To*</label>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="to_dt" value="{{ old('to_dt',$allotment->to_dt) }}" required
                                @cannot('manage',$allotment)
                                    readonly
                                @endcan
                            >
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col col-md-3"></div>
                        <div class="col col-md-4">
                            <input type="checkbox" id="admitted" name="admitted" {{ $allotment->admitted?" checked ":""}} disabled>
                            <label for="admitted">Whether admitted?</label>
                            <br>
                            <input type="checkbox" id="valid" name="valid" {{ $allotment->valid?" checked ":""}}
                                @cannot('manage',$allotment)
                                    disabled
                                @endcan
                            >
                            <label for="valid">Whether valid?</label>
                            <br>
                            <input type="checkbox" id="finished" name="finished" {{ $allotment->finished?" checked ":""}}
                                @cannot('manage',$allotment)
                                    disabled
                                @endcan
                            >
                            <label for="finished">Whether finished?</label>
                            <br>
                        </div>
                    </div>
                @endcan
                
                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <a class="btn btn-secondary" href="{{ $back_link }}">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="update">Update</update>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $("input[name='start_yr']").keyup(function(){
        if($(this).val().length >= 4){
            vl = parseInt($(this).val()) + 1;
            $("input[name='end_yr']").val(vl);
        }
    });
});
</script>
</x-layout>
