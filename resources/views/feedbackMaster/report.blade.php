<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Feedback report for {{ $feedback_master->title }}
                <p>
                    <a class="btn btn-primary btn-sm" href="/feedbackMaster/{{ $feedback_master->id }}">back</a>
                </p>
            </x-slot>
            <div>
                <table class="table">
                    <tr>
                        <th>Total number of feedbacks</th>
                        <td>{{ $report['no_of_feedbacks'] }}</td>
                    </tr>
                    <tr>
                        <th>Total number of users</th>
                        <td>{{ $report['no_of_users'] }}</td>
                    </tr>
                    <tr>
                        <th>Number of Criteria</th>
                        <td>{{ $report['no_of_criteria'] }}</td>
                    </tr>
                </table>
                <table class="table">
                    @foreach ($feedback_criteria as $fc)
                        <tr>
                            <td>{{ $fc->serial }}.</td>
                            <td>{{ $fc->criteria }}</td>
                            <td>
                            @if($fc->type == 'Rating')
                                {{ $fc->average() }}
                            @elseif($fc->type == 'Multiple choice')
                                <ul>
                                @foreach($fc->feedback_options as $opt)
                                    <li>{{ $opt->option }}: {{ $opt->no_of_count() }}</li>
                                @endforeach
                                </ul>
                            @else
                                <ul>
                                @foreach($fc->strings() as $str)
                                    <li>{{ $str->string }}</li>
                                @endforeach
                                </ul>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </x-block>
    </x-container>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
</x-layout>
