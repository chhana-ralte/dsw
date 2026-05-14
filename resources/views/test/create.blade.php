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
                <form method="post" action="/testing">
                    @csrf
                    <div class="row">
                        <div class="col col-md-4">
                            <label for="num">Number</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="num" class="form-control">
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
