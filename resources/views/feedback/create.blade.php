<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback
            </x-slot>
            <div>
                <form method="post" action="/feedback">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="customRange" class="form-label">Custom range</label>
                        <input type="range" class="form-range" id="customRange" name="costomRange" min=0 max=10>
                    </div>

                    <div class="mb-3">
                        <label for="quality" class="form-label">How do you rate the mess quality</label>
                        <input type="range" class="form-range" id="quality" name="quality" min=0 max=10>
                    </div>

                    <div class="mb-3">
                        <label for="variety" class="form-label">How do you rate the mess variety</label>
                        <input type="range" class="form-range" id="variety" name="variety" min=0 max=10>
                    </div>

                    <div class="mb-3">
                        <label for="satisfaction" class="form-label">What is your satisfaction with the current mess?</label>
                        <input type="range" class="form-range" id="satisfaction" name="satisfaction" min=0 max=10>
                    </div>

                    <div class="form-check mb-3">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </x-block>
    </x-container>
</x-layout>