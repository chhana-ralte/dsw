<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create detail of remark about {{ $person_remark_detail->person_remark->person->name }}
                <p>
                    <a href="/person/{{ $person_remark_detail->person_remark->person->id }}/person_remark/" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>                
            <form method="post" action="/person_remark_detail/{{ $person_remark_detail->id }}">
                @csrf
                @method('PUT')
                <div>
                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Reporting date
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="remark_dt" value="{{ $person_remark_detail->person_remark->remark_dt }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Remark
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="remark" class="form-control" value="{{ $person_remark_detail->person_remark->remark }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Score (worst = -5, best=5, neutral=0)
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="score" class="form-control" value="{{ $person_remark_detail->person_remark->score }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Detail to be entered here
                        </div>
                        <div class="col col-md-4">
                            <textarea name="detail" class="form-control" required>{{ old('detail',$person_remark_detail->detail) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                        </div>
                        <div class="col col-md-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>



        </x-block>
    </x-container>
</x-layout>
