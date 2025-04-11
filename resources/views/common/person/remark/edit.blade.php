<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Edit Remark(s) about {{ $person_remark->person->name }}
                <p>
                    <a href="/person/{{ $person_remark->person->id }}/person_remark/" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>                
            <form method="post" action="/person_remark/{{ $person_remark->id }}">
                @csrf
                @method('PUT')
                <div>
                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Reporting date
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="remark_dt" value="{{ old('remark_dt',$person_remark->remark_dt) }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Remark (Only subject, detail can be entered later)
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="remark" class="form-control" value="{{ old('remark',$person_remark->remark) }}" required>
                        </div>
                    </div>

                    <div class="form-group row pt-3">
                        <div class="col col-md-4">
                            Score (worst = -5, best=5, neutral=0)
                        </div>
                        <div class="col col-md-4">
                            <select name="score" class="form-control">
                                @for($i=-5;$i<=5;$i++)
                                    <option value="{{ $i }}" {{ $i==$person_remark->score?' selected ':''}}>{{ $i }}</option>
                                @endfor
                            </select>
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
