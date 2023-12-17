<!DOCTYPE html>
<html lang="en">

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
        <button onclick="switchGraphSet('previous')">Previous</button>
        <button onclick="switchGraphSet('next')">Next</button>
    </div>

    <script>
        console.log('Script is running');
        let currentGraph = 'A'; // Initial graph type
        let currentDataSetIndex = 0; // Index of the current data set
        let sensorSets; // Array to store sets of 1 to 8 sensor data
        let chartInstance; // Store the Chart.js instance

        fetch('fm_api.php')
            .then(response => response.json())
            .then(data => {
                // Use the fetched data here
                console.log(data);
                // Divide the data into sets of 1 to 8 sensors
                sensorSets = divideDataIntoSets(data.data, 8);
                console.log('currentDataSetIndex: ' + currentDataSetIndex);
                createChart(sensorSets[currentDataSetIndex]);
            })
            .catch(error => console.error('Error fetching data:', error));

        function divideDataIntoSets(data, sensorsPerSet) {
            const sets = [];
            for (let i = 0; i < data.length; i += sensorsPerSet) {
                sets.push(data.slice(i, i + sensorsPerSet));
            }
            console.log('sets:', sets);
            console.log(sets);
            return sets;
        }

        function createChart(data) {
            console.log('Creating chart...');

            const maxY = data.length * 5;

            const sensors = data.map(item => item['sensor']);
            const values = currentGraph === 'A' ? data.map(item => item['value1']) : data.map(item => item['value2']);

            const config = {
                type: 'line',
                data: {
                    labels: values,
                    datasets: [{
                        data: sensors,
                        label: currentGraph === 'A' ? 'Displacement A (Deg)' : 'Displacement B (Deg)',
                        borderColor: getRandomColor(),
                        borderWidth: 1,
                        pointRadius: 5,
                        type: 'line',
                    }],
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            min: -60,
                            max: 60,
                            ticks: {
                                stepSize: 5,
                                callback: function(value) {
                                    return value % 10 === 0 ? value : '\u200B'; // Add zero-width space for non-labeled ticks
                                },
                            },
                            title: {
                                display: true,
                                text: currentGraph === 'A' ? 'Displacement A (Deg)' : 'Displacement B (Deg)',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: (context) => context.tick.value === 0 ? 'rgba(0,0,0,1)' : 'rgba(0,0,0,0.1)',
                                lineWidth: (context) => context.tick.value === 0 ? 0.75 : 1,
                            },
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            min: -maxY,
                            max: 0,
                            ticks: {
                                stepSize: 5,
                                reverse: false,
                                callback: function(value, index, values) {
                                    return Math.abs(value) + 'm';
                                },
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Depth (m)',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                        },
                    },
                },
            };

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