<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//below two statements will stop sending errors on the client request/ ajax request 
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);

//change here dont use the variables for database connection which is used elsewhere for make connection

//the admin login here is working cause i when tried to login this page without skip-grant-tables in mysql.ini file then the localhost refused to connect and said you dont have the right to connect to admin. so just integrate the user and admin login in this.

// require 'db_connection.php';
// require_once("../dbcon.php");
// // SQL query to retrieve device data based on the device ID
// $sql = "SELECT *, inclino_device_data.id AS ddid FROM inclino_device_data
// LEFT JOIN inclino_devices ON inclino_devices.id = inclino_device_data.device_id
// WHERE inclino_device_data.device_id=" . $device_id . " ORDER BY date_time DESC";

// Set the default timezone
date_default_timezone_set('Asia/Kolkata');


$servername = 'localhost';
$username = 'alwr_admin';
$password = 'admin@123';
$dbname = 'site_alwr';

// Create connection
$conn = new mysqli($servername , $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle GET request to insert data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the keys exist in the $_GET array before accessing them
    $deviceNumber = isset($_GET['device_number']) ? $_GET['device_number'] : null;
    $sensor = isset($_GET['sensor']) ? $_GET['sensor'] : null;
    $value1 = isset($_GET['value1']) ? $_GET['value1'] : null;
    $value2 = isset($_GET['value2']) ? $_GET['value2'] : null;

    // Only attempt to insert data if all parameters are present
    if ($deviceNumber && $sensor && $value1 && $value2) {
        // Fetch the id of the device with the given device_number from the inclino_devices table
        $sql = "SELECT id FROM inclino_devices WHERE device_number = '$deviceNumber' ";
        $query = mysqli_query($conn, $sql); // Use $conn instead of $con
        $output = mysqli_fetch_assoc($query);

        // If a device with the given device_number exists, insert data into the inclino_device_data table
        if (!empty($output)) {
            $device_id = $output['id'];
            $sql = "INSERT INTO `inclino_device_data` (device_id, sensor, value1, value2, date_time) VALUES ($device_id,'$sensor','$value1','$value2','" . date('Y-m-d H:i:s') . "')";
            // Execute the SQL query
            if (mysqli_query($conn, $sql)) { // Use $conn instead of $con
                echo "Data inserted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Use $conn instead of $con
            }
        }
    }
}

// Fetch data from the 'inclino_device_data' table
// $sqlSelect = "SELECT * FROM inclino_device_data";
// $result = $conn->query($sqlSelect);

// $data = array();

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }
// }

// // Wrap the data array in an object with a "data" key
// $response = array('data' => $data);

// // Close the database connection
// $conn->close();
// // Return the data as JSON
// header('Content-Type: application/json');
// echo json_encode($response);

exit();
