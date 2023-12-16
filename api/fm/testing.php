<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Line Plot</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <script>
function createChart(data) {
    const cumulativeNegativeDepth = data.map(item => item['Cumulative Negative Depth']);
    const aValues = data.map(item => item['A']);

    const config = {
        type: 'line',
        data: {
            labels: aValues,
            datasets: [{
                label: 'Cumulative Negative Depth vs A',
                data: cumulativeNegativeDepth,
                borderColor: 'rgba(75, 192, 192, 100)',
                borderWidth: 1,
                pointRadius: 5,
                // pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                fill: false,
                tension: 0.2,
                spanGaps: false
            }],
        },
        options: {
    scales: {
        x: {
            type: 'linear',
            position: 'bottom',
            ticks: {
                stepSize: 5,
                callback: function (value) {
                    return value % 10 === 0 ? value : '\u200B'; // Add zero-width space for non-labeled ticks
                },
            },
            max: 40, // Set the maximum value for the x-axis
            min: -40, // Set the minimum value for the x-axis
            suggestedMax: 40, // Suggested maximum value for the x-axis
            suggestedMin: -40, // Suggested minimum value for the x-axis
            grid: {
                color: (context) => context.tick.value === 0 ? 'rgba(0,0,0,1)' : 'rgba(0,0,0,0.1)',
                lineWidth: (context) => context.tick.value === 0 ? 2 : 1,
            },
            title: {
                display: true,
                text: 'A',
            },
        },
        y: {
            title: {
                display: true,
                text: 'Cumulative Negative Depth',
            },
        },
    },
},

    };

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, config);
}



        // Test Data
        const testData = [
            { 'Cumulative Negative Depth': -18.0, 'A': 1.63 },
            { 'Cumulative Negative Depth': -36.0, 'A': -0.74 },
            { 'Cumulative Negative Depth': -60.0, 'A': -2.07 },
            { 'Cumulative Negative Depth': -90.0, 'A': -2.32 },
            { 'Cumulative Negative Depth': -126.0, 'A': 2.23 },
            { 'Cumulative Negative Depth': -168.0, 'A': -1.78 },
            { 'Cumulative Negative Depth': -216.0, 'A': -1.93 },
            { 'Cumulative Negative Depth': -222.0, 'A': 7.05 },
            { 'Cumulative Negative Depth': -234.0, 'A': 1.63 },
            { 'Cumulative Negative Depth': -252.0, 'A': -0.76 },
            { 'Cumulative Negative Depth': -276.0, 'A': -2.08 },
            { 'Cumulative Negative Depth': -306.0, 'A': -2.33 },
            { 'Cumulative Negative Depth': -342.0, 'A': 2.21 },
            { 'Cumulative Negative Depth': -384.0, 'A': -1.81 },
            { 'Cumulative Negative Depth': -432.0, 'A': -1.94 },
        ];

        // Call the createChart function with test data
        createChart(testData);
    </script>
</body>

</html>
