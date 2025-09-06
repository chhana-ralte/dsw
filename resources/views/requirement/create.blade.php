<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Kindly select the requirement for current semester
            </x-slot>


            @if(count($allotment->person->requirements)>0)
                <div style="width:100%; overflow-x:auto">









                    <table class="table">
                        <tr>
                            <th>Sl</th>
                            <td>For session</td>
                            <td>Hostel</td>
                            <td>Room type</td>
                        </tr>
                        <?php $sl=1 ?>
                        @foreach($requirements as $req)
                            <tr>
                                <th>{{ $sl++ }}</th>
                                <td>{{ $req->sessn->name() }}</td>
                                <td>{{ $req->hostel->name }}</td>
                                <td>{{ $req->roomtype }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @if($allotment->person->requirement(App\Models\Sessn::current()->next()->id))
                Current requirement submitted.
            @else
                <div style="width: 100%; overflow-x:auto">
                    <form method="post" action="/allotment/{{ $allotment->id }}/requirement">
                        @csrf
                        <div class="form-group row pt-2">
                            <div class="col-md-3">
                                <label for="sessn">Requirement for session:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="sessn" value="{{ App\Models\Sessn::current()->name() }}" disabled>
                                @error('sessn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <div class="col-md-3">
                                <label for="hostel">Option of Hostel</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="hostel" value="{{ $allot_hostel->hostel->name }}" readonly>
                                {{-- <select class="form-control" name="hostel" readonly>
                                    @foreach(App\Models\Hostel::where('gender',$allotment->person->gender)->get() as $h)
                                        <option value="{{ $h->id }}" {{ $allot_hostel->hostel->id==$h->id?' selected ':''}}>{{ $h->name }}</option>
                                    @endforeach
                                </select> --}}
                                @error('hostel')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <div class="col-md-3">
                                <label for="roomcapacity">Option of room type</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="roomcapacity">
                                    <option value="1" {{ $allot_seat->seat->room->capacity==1?' selected ':''}}>Single</option>
                                    <option value="2" {{ $allot_seat->seat->room->capacity==2?' selected ':''}}>Double</option>
                                    <option value="3" {{ $allot_seat->seat->room->capacity==3?' selected ':''}}>Triple</option>
                                    <option value="4" {{ $allot_seat->seat->room->capacity==4?' selected ':''}}>Dorm</option>
                                </select>
                                @error('roomcapacity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-4">

                                <a class="btn btn-secondary" href="/allotment/{{ $allotment->id }}/requirement">Back</a>
                                <button class="btn btn-primary btn-submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            @endif
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-submit").click(function(){
                $("form[name='frm-submit']").submit();
            });
        });
    </script>
</x-layout>
