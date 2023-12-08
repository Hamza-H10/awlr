<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//below two statements will stop sending errors on the client request/ ajax request 
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);

//change here dont use the variables for database connection which is used elsewhere for make connection
// Assuming you have a MySQL database named 'site_alwr'
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "site_alwr";

$servername = 'localhost';
$username = 'alwr_admin';
$password = 'admin@123';
$dbname = 'site_alwr';

// $dbhost = 'localhost';
// $dbuser = 'alwr_admin';
// $dbpass = 'admin@123';
// $dbname = 'site_alwr';

// $dbhost = 'localhost';
// $dbuser = 'root';
// $dbpass = '';
// $dbname = 'site_alwr';


// Create connection
$conn = new mysqli($servername , $username, $password, $dbname);
// $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// add defaul indian timezone here
date_default_timezone_set('Asia/Kolkata');
// $today = date(''Y-m-d H:i:s')

// Handle GET request to insert data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the keys exist in the $_GET array before accessing them
    $deviceNumber = isset($_GET['device_number']) ? $_GET['device_number'] : null;
    $sensor = isset($_GET['sensor']) ? $_GET['sensor'] : null;
    $value1 = isset($_GET['value1']) ? $_GET['value1'] : null;
    $value2 = isset($_GET['value2']) ? $_GET['value2'] : null;
    $deviceStatus = isset($_GET['$device_status']) ? $_GET['$device_status'] : null;

    // Only attempt to insert data if all parameters are present
    if ($deviceNumber && $sensor && $value1 && $value2 && $deviceStatus) {
        // Get the current date and time in 'Asia/Kolkata' time zone
        $currentDateTime = date('Y-m-d H:i:s');

        // Insert data into the 'inclino_device_data' table
        $sqlInsert = "INSERT INTO inclino_device_data (device_number, sensor, value1, value2, device_status) VALUES ('$deviceNumber', '$sensor', '$value1', '$value2', '$deviceStatus')";


        if ($conn->query($sqlInsert) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $sqlInsert . "<br>" . $conn->error;
        }
    }
}

// Fetch data from the 'inclino_device_data' table
$sqlSelect = "SELECT * FROM inclino_device_data";
$result = $conn->query($sqlSelect);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Wrap the data array in an object with a "data" key
$response = array('data' => $data);

// Close the database connection
$conn->close();
// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($response);

exit();
