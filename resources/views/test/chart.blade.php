<!DOCTYPE html>
<html>
<head>
    <title>Chart Example</title>
</head>
<body>
    <canvas id="myChart"></canvas>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // or 'line', 'pie', etc.
            data: {
                labels: ['January', 'February', 'March', 'April'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3, 5],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {}
        });
    </script>
</body>
</html>
