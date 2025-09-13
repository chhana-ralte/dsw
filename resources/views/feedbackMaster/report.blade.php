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
            </div>
        </x-block>
    </x-container>
    <x-container>
        @foreach ($feedback_criteria as $fc)
            <x-block class="col-md-6">
                <h4>{{ $fc->serial }}. {{ $fc->criteria }}</h4>
                <div>
                    @if ($fc->type == 'Rating')
                        Average scode : <b>{{ $fc->average() }}</b>
                        <canvas id="{{ $fc->id }}" name="chart"></canvas>
                    @elseif($fc->type == 'Multiple choice')
                        <ul>
                            @foreach ($fc->feedback_options as $opt)
                                <li>{{ $opt->option }}: {{ $opt->no_of_count() }}</li>
                            @endforeach
                        </ul>
                        <canvas id="{{ $fc->id }}" name="chart"></canvas>
                    @else
                        Click <a class="btn btn-primary btn-sm"
                            href="/feedbackCriteria/{{ $fc->id }}/report-string">here</a> to view the details.
                        {{-- <ul>
                            @foreach ($fc->strings() as $str)
                                <li>{{ $str->string }}</li>
                            @endforeach
                        </ul> --}}
                    @endif
                </div>
            </x-block>
        @endforeach
    </x-container>

    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            load_charts();


            // alert("asdasdas");
        });
    </script>

    <script>
        function load_charts() {
            var canvases = $("canvas").get();
            //alert(canvases.length);
            for (i = 0; i < canvases.length; i++) {
                // const ctx = document.getElementById('myChart').getContext('2d');
                const ctx = canvases[i];
                // alert(ctx.id);
                $.ajax({
                    type: "get",
                    url: "/ajax/feedback_criteria/" + ctx.id + "/report_chart",

                    success: function(data, status) {
                        const myChart = new Chart(ctx, {
                            type: 'bar', // or 'line', 'pie', etc.
                            data: {
                                labels: data
                                    .labels, //['1', '2', '3', '4', '5', '6', '7', '8', '9' ,'10'],
                                datasets: [{
                                    label: 'No. of feedback',
                                    data: data.data, //[12, 19, 30, 5, 6, 9, 10, 6, 0, 4],
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {}
                        });
                    },
                    error: function() {
                        alert("Error")
                    },
                });
                // const myChart = new Chart(ctx, {
                //     type: 'bar', // or 'line', 'pie', etc.
                //     data: {
                //         labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9' ,'10'],
                //         datasets: [{
                //             label: 'No. of feedback',
                //             data: [12, 19, 30, 5, 6, 9, 10, 6, 0, 4],
                //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
                //             borderColor: 'rgba(75, 192, 192, 1)',
                //             borderWidth: 1
                //         }]
                //     },
                //     options: {}
                // });
            }
        }
    </script>
</x-layout>
