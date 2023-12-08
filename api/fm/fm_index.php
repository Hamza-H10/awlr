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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Inclino Device Data</h2>
        <table id="deviceDataTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Device Number</th>
                    <th>Sensor</th>
                    <th>X Axis</th>
                    <th>Y Axis</th>
                    <th>Date Time</th>
                    <th>Device status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            var dataTable = $('#deviceDataTable').DataTable({
                "ajax": {
    "url": "fm_api.php", // Relative path to the file
    "dataSrc": "data"
},
                "columns": [{
                        "data": "device_number"
                    },
                    {
                        "data": "sensor"
                    },
                    {
                        "data": "value1"
                    },
                    {
                        "data": "value2"
                    },
                    {
                        "data": "date_time"
                    },
                    {
                        "data": "device_status"
                    }
                ]
            });
        });
    </script>
</body>
</html>