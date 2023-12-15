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
        <button onclick="switchGraphSet('previous')">Previous Set</button>
        <button onclick="switchGraphSet('next')">Next Set</button>
    </div>

    <script>
        console.log('Script is running');
        let currentGraph = 'A'; // Initial graph type
        let currentDataSetIndex = 0; // Index of the current data set
        let chartInstance; // Store the Chart.js instance
        let sensorSets; // Array to store sets of 1 to 8 sensor data

        fetch('fm_api.php')
            .then(response => response.json())
            .then(data => {
                // Use the fetched data here
                console.log(data);
                // Divide the data into sets of 1 to 8 sensors
                sensorSets = divideDataIntoSets(data.data, 8);
                createChart(sensorSets[currentDataSetIndex]);
            })
            .catch(error => console.error('Error fetching data:', error));

        function divideDataIntoSets(data, sensorsPerSet) {
            const sets = [];
            for (let i = 0; i < data.length; i += sensorsPerSet) {
                sets.push(data.slice(i, i + sensorsPerSet));
            }
            return sets;
        }

        function createChart(data) {
            console.log('Creating chart...');

            const seriesCollection = [];
            const maxY = data.length * 5;

            // Define depth values for each sensor
            const depthValues = data.reduce((acc, item, index) => {
                const sensor = parseInt(item.sensor);
                acc[sensor] = -5 * index;
                return acc;
            }, {});

            // Loop through selected items
            data.forEach(item => {
                const sensor = parseInt(item.sensor);
                const depth = depthValues[sensor];
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
                seriesCollection[sensor].values.push({
                    x: value,
                    y: depth,
                    label: `Value: ${value}\nDate Time: ${item.date_time}`
                });
            });

            // Print seriesCollection to the console
            console.log('Series Collection:', seriesCollection);

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
                                stepSize: 5,
                            },
                            title: {
                                display: true,
                                text: currentGraph === 'A' ? 'Displacement A (Deg)' : 'Displacement B (Deg)',
                            },
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            min: -maxY, // Make min negative to reverse the ticks
                            max: 0,
                            ticks: {
                                stepSize: 5,
                                reverse: false, // Set reverse to false
                                callback: function(value, index, values) {
                                    return Math.abs(value) + 'm';
                                },
                            },
                            title: {
                                display: true,
                                text: 'Depth (m)',
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    if (label) {
                                        return `${label}`;
                                    }
                                    return null;
                                },
                            },
                        },
                    },
                },
            };
            console.log('Chart config:', config);

            const ctx = document.getElementById('myChart').getContext('2d');
            chartInstance = new Chart(ctx, config);
        }

        function toggleGraph() {
            console.log("inside toggleGraph function");
            currentGraph = currentGraph === 'A' ? 'B' : 'A';
            chartInstance.destroy(); // Destroy the current chart instance
            createChart(sensorSets[currentDataSetIndex]);
        }

        function switchGraphSet(direction) {
            if (direction === 'previous' && currentDataSetIndex > 0) {
                currentDataSetIndex--;
            } else if (direction === 'next' && currentDataSetIndex < sensorSets.length - 1) {
                currentDataSetIndex++;
            }
            chartInstance.destroy(); // Destroy the current chart instance
            createChart(sensorSets[currentDataSetIndex]);
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