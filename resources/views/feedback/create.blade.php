<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback
            </x-slot>
            <div>
                <form method="post" action="/feedback">
                    @csrf
                    @foreach ($feedback_criteria as $crit)
                        @if ($crit->type == 'Short answer')
                            <div class="mt-3 mb-3">
                                <label for="criteria_{{ $crit->id }}" class="form-label">{{ $crit->criteria }}</label>
                                <input type="text" class="form-control" id="criteria_{{ $crit->id }}"
                                    placeholder="{{ $crit->criteria }}" name="criteria_{{ $crit->id }}">
                            </div>
                        @elseif($crit->type == 'Rating')
                            <div class="mb-3">
                                <label for="criteria_{{ $crit->id }}"
                                    class="form-label">{{ $crit->criteria }}</label>
                                <input type="range" class="form-range" id="criteria_{{ $crit->id }}"
                                    name="criteria_{{ $crit->id }}" min=0 max=10>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="{{ $crit->id }}" class="form-label">{{ $crit->criteria }}</label>
                                <select class="form-control" id="{{ $crit->id }}"
                                    name="criteria_{{ $crit->id }}">
                                    @foreach ($crit->options as $opt)
                                        <option value="{{ $opt->id }}">{{ $opt->option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="criteria_{{ $crit->id }}"
                                    class="form-label">{{ $crit->criteria }}</label>
                                <ul>
                                    @foreach ($crit->options as $opt)
                                        <li><input type="radio" id="opt_{{ $opt->id }}"
                                                name="criteria_{{ $crit->id }}" value="{{ $opt->id }}">
                                            <label for="opt_{{ $opt->id }}"
                                                class="form-label">{{ $opt->option }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                                </select>
                            </div>
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </x-block>
    </x-container>
</x-layout>
