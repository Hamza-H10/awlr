<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$data = array(
    array(
        'x_angle' => 10,
        'y_angle' => 20,
        'created_at' => '2022-01-01T00:00:00Z',
        'entry_id' => 1
    ),
    array(
        'x_angle' => 15,
        'y_angle' => 25,
        'created_at' => '2022-01-02T00:00:00Z',
        'entry_id' => 2
    )
    // Add more data here
);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(array('data' => $data));
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receivedData = json_decode(file_get_contents('php://input'), true);
    error_log('Received data: ' . print_r($receivedData, true));
    echo json_encode(array('success' => true));
}

?>
<script>
    function fetchAndDisplayData() {
        fetch('data.php')
            .then(response => response.json())
            .then(data => {
                var table = document.getElementById('data-table');
                var tableBody = table.getElementsByTagName('tbody')[0];

                data.data.forEach(user => {
                    var row = tableBody.insertRow();
                    var cell1 = row.insertCell();
                    var cell2 = row.insertCell();
                    var cell3 = row.insertCell();
                    var cell4 = row.insertCell();

                    cell1.innerHTML = user.x_angle || 0;
                    cell2.innerHTML = user.y_angle || 0;
                    cell3.innerHTML = user.created_at || '';
                    cell4.innerHTML = user.entry_id || 0;
                });
            })
            .catch(error => console.log(error));
    }
</script>