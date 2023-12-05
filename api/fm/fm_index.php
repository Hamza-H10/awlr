<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flowmeter Device Data</title>
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
        <h2>Flowmeter Device Data</h2>
        <table id="deviceDataTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Device Number</th>
                    <th>Sensor</th>
                    <th>Value 1</th>
                    <th>Value 2</th>
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
                    "url": "http://localhost/awlr/api/fm/fm_api.php",
                    "dataSrc": "data" // Use "data" as the key for the array of objects
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
                    }
                ]
            });
        });
    </script>
</body>

</html>