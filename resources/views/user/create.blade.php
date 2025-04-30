<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Create User
                <p>
                    <a class="btn btn-secondary btn-sm" href="/user">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/user/" class="pt-2">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $id }}">

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name"  value="{{ old('name',$type != ''?$person->name:'') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if(isset($warden))
                    <div class="form-group row pt-2">
                        <div class="col-md-3">
                            <label for="hostel">Warden of</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="hostel"  value="{{ old('hostel',$type != ''?$warden->hostel->name:'') }}" {{ $type!=''?' readonly ':'' }}>
                            @error('hostel')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                @if(isset($allotment))
                    <div class="form-group row pt-2">
                        <div class="col-md-3">
                            <label for="allotment">Initial resident of</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="allotment"  value="{{ old('allotment',$allotment->hostel->name) }}" disabled>
                            @error('allotment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

{{--                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="email" >
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>--}}
                <div class="form-group row pt-2">
                    <label for="password" class="col col-md-3">Password</label>
                    <div class="col col-md-4">
                        <input type="password" class="form-control" name="password" value="" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <label for="password_confirmation" class="col col-md-3">Confirm password</label>
                    <div class="col col-md-4">
                        <input type="password" class="form-control" name="password_confirmation" value="" required>
                    </div>
                </div>



                
                <div class="form-group row pt-2">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-4">
                        <x-button type="a" href="/user">Back</x-button>
                        <x-button type="submit">Submit</x-button>
                    </div>
                </div>
            </form>
        </x-block>
    </x-container>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("button.btn-delete").click(function(){
        if(confirm('Are you sure you want to delete?')){
            
        }
    });
})
</script>
</x-layout>
