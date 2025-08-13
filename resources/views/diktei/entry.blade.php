<x-diktei>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Interdisciplinary Course Selection portal
            </x-slot>

        </x-block>
        <x-block>
            <form id="frmEntry" method="post" action="/diktei/option">
                @csrf
                <div class="mb-3">
                    <label for="mzuid" class="col-form-label">Enter your MZU ID (Application Form Number)</label>
                    <input class="form-control" name="mzuid" placeholder="e.g., MZU0000012345" required>
                </div>
                <button type="submit" class="submit-btn btn btn-primary">Proceed</button>
            </form>
        </x-block>




    </x-container>



    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

        });
    </script>
</x-diktei>
