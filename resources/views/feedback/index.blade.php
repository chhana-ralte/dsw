<x-layout>
    @if(auth()->user())
        @cannot('gives', App\Models\Feedback::class)
            <x-container>
                <x-block>
                    <x-slot name="heading">
                        You are not authorised to give feedback.
                    </x-slot>
                </x-block>
            </x-container>
        @endcannot
    @endif
    <x-container>
        <x-block class="col-md-6">
            <x-slot name="heading">
                Feedback on the quality of mess service.
            </x-slot>
            <p>
            This questionnaire is designed to collect your feedback and opinion on the quality of food provided in the Hostel Mess catered by EIMI Foods during September 2024 to August 2025. Your responses will helps us better understand the current situation and identify areas for improvement in the proper management of hostel mess. Please answer the following questions honestly and at the best of your knowledge. The ratings for range between 1 to 5 as follows:
            </p>

            <ol>

                <li>Dissatisfied</li>
                <li>Slightly dissatisfied</li>
                <li>Neutral - Neither good nor bad</li>
                <li>Satisfied</li>
                <li>Extremely satisfied</li>

            </ol>
            <p>
                Period : 2024-25 (Odd), 2024-25(Even) and 2025-26(Odd)
            </p>
            <p>
                Only those who experience the mess during the aforesaid may give the feedback.
            </p>
            <p>

                <a class="btn btn-primary" href="/feedbackMaster/{{ $feedback_master->id }}/feedback/create">Proceed>></a>
            </p>
        </x-block>
    </x-container>
    @if(auth()->user() && auth()->user()->isAdmin())
        <x-container>
            <x-block class="col-md-6">
                <x-slot name="heading">
                    Actions
                </x-slot>

                <div class="btn-group justify-content-center">
                    <button class="btn btn-primary btn-action" id="open" value="open">Open</button>
                    <button class="btn btn-primary btn-action" id="close" value="close">Close</button>
                    <button class="btn btn-danger btn-action" id="clear" value="clear">Clear feedback</button>
                </div>

                <form method="post" name="frmAction" action="/fb/temp/action">
                    <input type="hidden" name="action">
                    @csrf
                </form>
            </x-block>
        </x-container>
    @endif

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("button.btn-action").click(function(){
                if(confirm("Are you sure you want to change the feedback status")){
                    $("input[name='action']").val($(this).val());
                    $("form[name='frmAction']").submit();
                    exit();
                }
            });
        });
    </script>
</x-layout>
