<x-layout>
    <x-container>
        <x-block class="col-md-10">
            <x-slot name="heading">
                Testing index
                <p>
                    <a class="btn btn-primary btn-sm" href="/testing/">Index</a>
                </p>
            </x-slot>
            <div style="width: 100%, overflow-x: auto">
                <form method="post" action="/testing/{{ $test->id }}">
                    @method('put')
                    @csrf
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="num">Number</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="number" name="num" class="form-control" value="{{ $test->num }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="dt">Date</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="dt" class="form-control" value="{{ $test->dt }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="str">String</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="str" class="form-control" value="{{ $test->str }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="txt">Text</label>
                        </div>
                        <div class="col col-md-4">
                            <textarea name="txt" class="form-control">{{ $test->txt }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-md-4">
                        </div>
                        <div class="col col-md-4">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>

        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {


        });
    </script>
</x-layout>
