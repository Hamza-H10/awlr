<?php
// Start a session to maintain state across requests
session_start();

// Get and sanitize parameters from the GET request
$action = filter_var($_GET['action'], FILTER_SANITIZE_STRING);
$user_id = filter_var($_GET['user'], FILTER_SANITIZE_STRING);
$device_id = filter_var($_GET['device'], FILTER_SANITIZE_STRING);

// Switch statement to handle different actions
switch ($action) {
	case "updatedevice":
		updatedevice($user_id, $device_id);
		break;
	default:
		// If no valid action is specified, return 0 (or handle as needed)
		return 0;
}

// Function to update device information
function updatedevice($userid, $deviceid)
{
	// Include the database connection file
	require_once("../dbcon.php");

	// SQL query to update the device information
	$sql = "UPDATE devices SET user_id=" . $userid . " WHERE id=" . $deviceid;

	// Array to store details (if needed)
	$details = array();

	// Execute the SQL query
	if (!$result = $conn->query($sql)) {
		// If the query fails, echo the error
		echo $conn->error;
	} else {
		// If the query is successful, echo 1 (or handle success as needed)
		echo 1;
	}
}

// Note: It's a good practice to close the PHP tag at the end of the file when no HTML follows
