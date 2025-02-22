<x-layout>
  <x-slot:heading>
    Login page
  </x-slot:heading>

  <form method='post' action='/login'>
  @csrf
    <x-container>
      <x-block>
        <div align="center">
          <div class="card" style="width: 400px" centered>
            <div class="card-header">
              Login form
            </div>
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-4">
                <Label>Username</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="username" required>
              </div>
            </div>
            <div class="form-group row pt-2">
              <div class="col-md-4">
                <Label>Password</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="password" name="password" required>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form-group row">
              <div class="col-md-3">
                <x-button type="submit">Login</x-button>
              </div>
            </div>

          </div>
        </div>
      </x-block>
    </x-container>
  </form>

</x-layout>