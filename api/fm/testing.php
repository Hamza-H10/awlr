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
    </div>

    <script>
        // Fetch data from server
        fetch('fm_api.php')
            .then(response => response.json())
            .then(data => {
                // Process data and update chart
                updateChart(data);
            })
            .catch(error => console.error('Error fetching data:', error));

        // Function to update the chart with the fetched data
        function updateChart(data) {
            // Process data and update chart as needed
            // Example: Assume data is an array of values
            const labels = [...]; // Set labels based on data
            const chartData = {
                labels: labels,
                datasets: [{
                    label: 'My Dataset',
                    data: data,
                    // Additional chart options...
                }]
            };

            // Create or update the chart
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                // Additional chart options...
            });
        }
    </script>
</body>

</html>
