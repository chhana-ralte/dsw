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

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" >
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="username" >
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    </div>
                </div>

                <div class="form-group row pt-2">
                    <div class="col-md-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="email" >
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
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
