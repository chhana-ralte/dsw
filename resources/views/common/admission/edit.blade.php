<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Admission status update for {{ $allotment->person->name }}
            </x-slot>

            <form method="post" action="/admission/{{ $admission->id }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="back_link" value="{{ $back_link }}">
                <div class="form-group row mb-3">
                    <label for="name" class="col col-md-3">Name</label>
                    <div class="col col-md-4">
                        <input type="text" class="form-control" name="name" value="{{ $allotment->person->name }}" readonly>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="sessn" class="col col-md-3">For session</label>
                    <div class="col col-md-4">
                        <select class="form-control" name="sessn">
                            @foreach($sessns as $sn)
                                <option value="{{ $sn->id }}" {{ old('sessn',$admission->sessn_id)==$sn->id?' selected ':'' }}>{{ $sn->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="payment_dt" class="col col-md-3">Payment date</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" name="payment_dt" value="{{ old('payment_dt',$admission->payment_dt) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="amount" class="col col-md-3">Amount</label>
                    <div class="col col-md-4">
                        <input type="numeric" class="form-control" name="amount" value="{{ old('amount',$admission->amount) }}" required>
                        @error('amount')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col col-md-3"></div>
                    <div class="col col-md-4">
                        <button class="btn btn-primary btn-create" type="submit">Update</update>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
</x-layout>
