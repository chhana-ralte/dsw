<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback
            </x-slot>
            <div>
                <form method="post" action="/feedbackMaster/{{ $feedback_master->id }}/feedback">
                    @csrf
                    @foreach ($feedback_criteria as $crit)
                        <div class="row my-3 justify-content-center">
                            <div class="col-md-5 border">
                                @if ($crit->type == 'Short answer')

                                    <h5 class="text-start text-primary">{{ $crit->criteria }}</h5>
                                    <input class="form-control mb-3" id="criteria_{{ $crit->id }}" name="criteria_{{ $crit->id }}" maxlength=20>
                                @elseif ($crit->type == 'Text')


                                    <h5 class="text-start text-primary">{{ $crit->criteria }}</h5>

                                    <textarea class="form-control mb-3" id="criteria_{{ $crit->id }}" name="criteria_{{ $crit->id }}" rows="5" maxlength="250"></textarea>
                                @elseif($crit->type == 'Rating')


                                    <h5 class="text-start text-primary">{{ $crit->criteria }}</h5>
                                    <div class="input-group mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Min</span>
                                        </div>
                                        <input type="range" class="form-control" min="1" max="5" id="criteria_{{ $crit->id }}"
                                            name="criteria_{{ $crit->id }}" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">Max</span>
                                        </div>
                                    </div>


                                @else


                                    <h5 class="text-start text-primary">{{ $crit->criteria }}</h5>
                                    <ul>
                                        @foreach ($crit->feedback_options as $opt)
                                            <li><input type="radio" id="opt_{{ $opt->id }}"
                                                    name="criteria_{{ $crit->id }}" value="{{ $opt->id }}">
                                                <label for="opt_{{ $opt->id }}"
                                                    class="form-label">{{ $opt->option }}</label>
                                            </li>
                                        @endforeach
                                    </ul>

                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="row my-3 justify-content-center">
                        <div class="col-md-5 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </x-block>
    </x-container>
</x-layout>
