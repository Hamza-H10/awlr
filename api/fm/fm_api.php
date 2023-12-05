<?php
// Assuming you have a MySQL database named 'site_alwr'
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site_alwr";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle GET request to insert data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Extract data from the URL parameters
    $deviceNumber = $_GET['device_number'];
    $sensor = $_GET['sensor'];
    $value1 = $_GET['value1'];
    $value2 = $_GET['value2'];

    // Insert data into the 'flowmeter_device_data' table
    $sqlInsert = "INSERT INTO flowmeter_device_data (device_number, sensor, value1, value2) VALUES ('$deviceNumber', '$sensor', '$value1', '$value2')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sqlInsert . "<br>" . $conn->error;
    }
}

// Fetch data from the 'flowmeter_device_data' table
$sqlSelect = "SELECT * FROM flowmeter_device_data";
$result = $conn->query($sqlSelect);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
