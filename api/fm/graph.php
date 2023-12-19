<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
        <button onclick="toggleGraph()">Toggle Graph</button>
        <button onclick="switchGraphSet('previous')">Previous</button>
        <button onclick="switchGraphSet('next')">Next</button>
        <button onclick="downloadChart()">Download Chart</button>
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
    // console.log(sets);
    return sets;
}
// Function to convert sensor values to equivalent depth values
function sensorDepth(sensorNumber) {
    // Assuming sensor values 1 to 8 correspond to depth values -40m to -5m
    return -40 + (sensorNumber - 1) * 5;
}

function createChart(data) {
    console.log('Inside createChart, data:', data);

    const sensors = data.map(item => sensorDepth(item['sensor'])); // Use 'sensorDepth' function to get depth values
    const values = currentGraph === 'A' ? data.map(item => item['value1']) : data.map(item => item['value2']);
    const dateTimes = data.map(item => item['date_time']); // Add this line to get date_time values

    const config = {
        type: 'line',
        data: {
            labels: values,
            datasets: [{
                data: sensors,
                label: currentGraph === 'A' ? 'Displacement A (Deg)' : 'Displacement B (Deg)',
                borderColor: getRandomColor(),
                borderWidth: 1.75,
                pointRadius: 5,
                type: 'line',
                fill: false,
                tension: 0.3,
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
                    title: {
                        display: true,
                        text: 'Sensor Depth',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const value = values[index];
                            // const depth = sensors[index];
                            const dateTime = dateTimes[index];
                            return `Depth: ${value}, Date-Time: ${dateTime}`;
                            // return `Depth: ${depth}, Date-Time: ${dateTime}`;
    
                        },
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

        function downloadChart() {
    const canvas = document.getElementById('myChart');

    html2canvas(canvas).then(function(canvas) {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF();

        pdf.addImage(imgData, 'PNG', 0, 0);
        pdf.save('chart.pdf');
    });
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