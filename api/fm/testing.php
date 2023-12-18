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
    const sensorValues = data.map(item => item['sensor']);
    const value1 = data.map(item => item['value1']);

    const config = {
        type: 'line',
        data: {
            labels: value1, // Use 'value1' for x-axis labels
            datasets: [{
                data: sensorValues, // Use 'sensor' values for y-axis
                borderColor: 'rgba(75, 192, 192, 100)',
                borderWidth: 1,
                pointRadius: 5,
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
                        callback: function(value) {
                            return value % 10 === 0 ? value : '\u200B';
                        },
                    },
                    max: 40,
                    min: -40,
                    suggestedMax: 40,
                    suggestedMin: -40,
                    grid: {
                        color: (context) => context.tick.value === 0 ? 'rgba(0,0,0,1)' : 'rgba(0,0,0,0.1)',
                        lineWidth: (context) => context.tick.value === 0 ? 2 : 1,
                    },
                    title: {
                        display: true,
                        text: 'Value1',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Sensor',
                    },
                },
            },
        },
    };

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, config);
}


        // Test Data
        const testData =[
    {
        "id": 371,
        "date_time": "2023-12-12 15:36:17",
        "device_number": 230,
        "sensor": 1,
        "value1": -1.88,
        "value2": -3.22
    },
    {
        "id": 372,
        "date_time": "2023-12-12 15:36:28",
        "device_number": 230,
        "sensor": 2,
        "value1": -0.78,
        "value2": -5.89
    },
    {
        "id": 373,
        "date_time": "2023-12-12 15:36:40",
        "device_number": 230,
        "sensor": 3,
        "value1": -2.33,
        "value2": -5.04
    },
    {
        "id": 374,
        "date_time": "2023-12-12 15:36:52",
        "device_number": 230,
        "sensor": 4,
        "value1": -2.03,
        "value2": -0.77
    },
    {
        "id": 375,
        "date_time": "2023-12-12 15:37:04",
        "device_number": 230,
        "sensor": 5,
        "value1": -1.33,
        "value2": 20.19
    },
    {
        "id": 376,
        "date_time": "2023-12-12 15:37:16",
        "device_number": 230,
        "sensor": 6,
        "value1": -3.07,
        "value2": 22.05
    },
    {
        "id": 377,
        "date_time": "2023-12-12 15:37:27",
        "device_number": 230,
        "sensor": 7,
        "value1": -6.86,
        "value2": 12.97
    },
    {
        "id": 378,
        "date_time": "2023-12-12 15:37:39",
        "device_number": 230,
        "sensor": 8,
        "value1": -0.32,
        "value2": 6.58
    }
];

    // Call the createChart function with test data
        createChart(testData);
    </script>
</body>

</html>