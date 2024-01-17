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
        <!-- DataTable -->
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
        <!-- Graph Button -->
        <a href="graph.php" class="btn btn-primary">Show Graph</a>
    </div>

    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            // DataTable Initialization
            var dataTable = $('#deviceDataTable').DataTable({
                "ajax": {
                    "url": "fm_api.php", // Relative path to the file
                    "dataSrc": "data"
                },
                "columns": [{
                        "data": "date_time"
                    },
                    {
                        "data": "device_number"
                        // "data": "device_id"
                    },
                    {
                        "data": "sensor"
                    },
                    {
                        "data": "value1"
                    },
                    {
                        "data": "value2"
                    }
                ]
            });
        });
    </script>
</body>
</html>