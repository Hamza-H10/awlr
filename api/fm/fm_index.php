<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inclino Device Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Inclino Device Data</h2>
        <button id="showGraphBtn" class="btn btn-primary">Show Graph</button>
        <table id="deviceDataTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Device Number</th>
                    <th>Sensor</th>
                    <th>X Angle(Deg)</th>
                    <th>Y Angle(Deg)</th>                   
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div id="graphContainer" class="mt-5">
            <canvas id="graphCanvas"></canvas>
        </div>
    </div>

    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            var dataTable = $('#deviceDataTable').DataTable({
                "ajax": {
                    "url": "fm_api.php", // Relative path to the file
                    "dataSrc": "data"
                },
                "columns": [
                    { "data": "date_time" },
                    { "data": "device_number" },
                    { "data": "sensor" },
                    { "data": "value1" },
                    { "data": "value2" }
                ]
            });

            // Chart.js configuration
            var ctx = document.getElementById('graphCanvas').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // X-axis labels
                    datasets: [{
                        label: 'Sensor',
                        data: [], // Y-axis data
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom'
                        },
                        y: {
                            min: 0
                        }
                    }
                }
            });

            // Show Graph button click event
            $('#showGraphBtn').click(function() {
                // Extract X and Y angle values from DataTable
                var xValues = dataTable.column('value1:name').data().toArray();
                var yValues = dataTable.column('value2:name').data().toArray();

                // Update Chart.js data
                chart.data.labels = xValues;
                chart.data.datasets[0].data = yValues;

                // Update the chart
                chart.update();

                // Scroll to the graph container
                $('html, body').animate({
                    scrollTop: $("#graphContainer").offset().top
                }, 500);
            });
        });
    </script>
</body>

</html>
