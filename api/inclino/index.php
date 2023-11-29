<!DOCTYPE html>
<html>

<head>
    <title>Get and display JSON Data</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <style>
        .cwhite {
            color: #FFFFFF
        }

        .table_datawindow {
            width: 100%;
            height: 100%;
            padding: 20px;
            border: 1px solid #CCC;
            background-color: #FFF;
            overflow: auto;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchAndDisplayData();
        });

        function fetchAndDisplayData() {
            fetch('https://api.thingspeak.com/channels/2345726/feeds.json?results=20').then(res => {
                    return res.json();
                })
                .then(data => {
                    var table = document.getElementById('data-table');
                    var tableBody = table.getElementsByTagName('tbody')[0];

                    data.feeds.forEach(user => {
                        var row = tableBody.insertRow();
                        var cell1 = row.insertCell();
                        var cell2 = row.insertCell();
                        var cell3 = row.insertCell();
                        var cell4 = row.insertCell();

                        cell1.innerHTML = user.field1 || 0;
                        cell2.innerHTML = user.field2 || 0;
                        cell3.innerHTML = user.created_at || '';
                        cell4.innerHTML = user.entry_id || 0;
                    });
                })
                .catch(error => console.log(error));
        }
    </script>

</head>

<body>
    <div id="table1_datawindow" class="table_datawindow">
        <table id="data-table" class="table table-striped">
            <thead>
                <tr>
                    <th>X Angle</th>
                    <th>Y Angle</th>
                    <th>Created at</th>
                    <th>Entry ID</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
</body>

</html>