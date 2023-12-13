<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';
include 'db_connection.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
        <button onclick="toggleGraph()">Toggle Graph</button>
    </div>

    <script>
        console.log('Script is running');
        let currentGraph = 'A'; // Initial graph type
        let chartInstance; // Store the Chart.js instance

        fetch('fm_api.php')
            .then(response => response.json())
            .then(data => {
                // Use the fetched data here
                console.log(data);
                createChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));

        function createChart(data) {
            const seriesCollection = [];
            const uniqueSensors = Array.from(new Set(data.data.map(item => parseInt(item.sensor))));
            const maxY = uniqueSensors.length * 5;

            // Loop through selected items
            data.data.forEach(item => {
                const sensor = parseInt(item.sensor);
                const depth = (uniqueSensors.length - sensor) * 5;
                const value = currentGraph === 'A' ? parseFloat(item.value1) : parseFloat(item.value2);

                if (!seriesCollection[sensor]) {
                    seriesCollection[sensor] = {
                        title: `Sensor ${sensor}`,
                        values: [],
                        fill: false,
                        borderColor: getRandomColor(),
                        borderWidth: 1,
                        tension: 0.2,
                    };
                }

                // Populate series with data points
                seriesCollection[sensor].values.push({ x: value, y: depth });
            });
// ----------------------------
            // Print seriesCollection to the console
    console.log('Series Collection:', seriesCollection);
// ------------------------------
            const config = {
                type: 'line',
                data: {
                    datasets: Object.values(seriesCollection),
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            min: -40,
                            max: 40,
                            ticks: {
                                stepSize: 10,
                            },
                            title: {
                                display: true,
                                text: currentGraph === 'A' ? 'Displacement A (Deg)' : 'Displacement B (Deg)',
                            },
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            min: 0,
                            max: maxY,
                            ticks: {
                                stepSize: 5,
                                reverse: true,
                                callback: function (value, index, values) {
                                    return Math.abs(value) + 'm';
                                },
                            },
                            title: {
                                display: true,
                                text: 'Depth (m)',
                            },
                        },
                    },
                },
            };

            const ctx = document.getElementById('myChart').getContext('2d');
            chartInstance = new Chart(ctx, config);
        }

        function toggleGraph() {
            currentGraph = currentGraph === 'A' ? 'B' : 'A';
            chartInstance.destroy(); // Destroy the current chart instance
            fetch('fm_api.php')
                .then(response => response.json())
                .then(data => {
                    createChart(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Function to generate random color
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</body>

</html>
