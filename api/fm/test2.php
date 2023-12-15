<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="https://cdn.plot.ly/plotly-latest.min.js"></script> -->
    <script src="https://cdn.plot.ly/plotly-1.58.4.min.js"></script>
</head>

<body>
    <div id="myChart"></div>
    <button onclick="toggleGraph()">Toggle Graph</button>
    <button onclick="switchGraphSet('previous')">Previous</button>
    <button onclick="switchGraphSet('next')">Next</button>

    <script>
        console.log('Script is running');
        let currentGraph = 'A'; // Initial graph type
        let currentDataSetIndex = 0; // Index of the current data set
        let sensorSets; // Array to store sets of 1 to 8 sensor data
        let chartInstance; // Store the Plotly.js instance

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
// -------------------------------------------------
// Example data
// let data = [
//     {date_time: "2023-12-12 15:36:17", device_number: "230", sensor: "1", value1: "-2.88", value2: "-3.22"},
//     {date_time: "2023-12-12 15:36:28", device_number: "230", sensor: "2", value1: "-1.78", value2: "-5.89"},
//     {date_time: "2023-12-12 15:36:40", device_number: "230", sensor: "3", value1: "-0.33", value2: "-5.04"},
//     {date_time: "2023-12-12 15:36:52", device_number: "230", sensor: "4", value1: "-4.03", value2: "-0.77"},
//     {date_time: "2023-12-12 15:37:04", device_number: "230", sensor: "5", value1: "-1.33", value2: "20.19"},
//     {date_time: "2023-12-12 15:37:16", device_number: "230", sensor: "6", value1: "-2.07", value2: "22.05"},
//     {date_time: "2023-12-12 15:37:27", device_number: "230", sensor: "7", value1: "-7.86", value2: "12.97"},
//     {date_time: "2023-12-12 15:37:39", device_number: "230", sensor: "8", value1: "-1.32", value2: "6.58"}
// ];

// // Use the example data here
// console.log(data);
// // Divide the data into sets of 1 to 8 sensors
// sensorSets = divideDataIntoSets(data, 8);
// createChart(sensorSets[currentDataSetIndex]);
// -------------------------------------------------
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
                name: `Sensor ${sensor}`,
                x: [],
                y: [],
                mode: 'lines+markers',
                marker: {
                    color: getRandomColor(),
                    line: { color: 'black', width: 2 } // Define line property within marker
                },
                line: { // Add this line attribute
                    color: 'red',
                    width: 2
                },
                type: 'scatter',
                hovertemplate: `Value: ${value}<br>Date Time: ${item.date_time}<extra></extra>`
            };
        }

        // Populate series with data points
        seriesCollection[sensor].x.push(value);
        seriesCollection[sensor].y.push(depth);
    });


    // Print seriesCollection to the console
    console.log('Series Collection:', seriesCollection);

    const layout = {
        xaxis: {
            title: currentGraph === 'A' ? 'Displacement A (Deg)' : 'Displacement B (Deg)',
            range: [-60, 60],
            tickmode: 'array',
            tickvals: [-40, -35, -30, -25, -20, -15, -10, -5, 0, 5, 10, 15, 20, 25, 30, 35, 40],
            ticktext: ['-40', '-35', '-30', '-25', '-20', '-15', '-10', '-5', '0', '5', '10', '15', '20', '25', '30', '35', '40'],
        },
        yaxis: {
            title: 'Depth (m)',
            // autorange: 'reversed',
            tickmode: 'array',
            tickvals: Object.values(depthValues),
            ticktext: Object.values(depthValues).map(value => Math.abs(value) + 'm'),
        }
    };

    const config = { responsive: true };
    Plotly.newPlot('myChart', Object.values(seriesCollection), layout, config);
}


        function toggleGraph() {
            console.log("inside toggleGraph function");
            currentGraph = currentGraph === 'A' ? 'B' : 'A';
            createChart(sensorSets[currentDataSetIndex]);
        }

        function switchGraphSet(direction) {
            if (direction === 'previous' && currentDataSetIndex > 0) {
                currentDataSetIndex--;
            } else if (direction === 'next' && currentDataSetIndex < sensorSets.length - 1) {
                currentDataSetIndex++;
            }
            createChart(sensorSets[currentDataSetIndex]);
        }

        // Function to generate random color
        function getRandomColor() {
            return `#${Math.floor(Math.random() * 16777215).toString(16)}`;
        }
    </script>
</body>

</html>
