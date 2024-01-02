<?php
// Include the database connection file
require_once("../dbcon.php");

// Check if the form is submitted using POST method
if ($_POST) {
	// Sanitize and retrieve form data
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$num = filter_var($_POST['num'], FILTER_SANITIZE_STRING);
	$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

	// SQL query to update the devices table with the new data
	$sql = "UPDATE devices SET device_number = '$num', device_short_name = '$name' WHERE id=" . $id;

	// Execute the SQL query
	if (!$result = $conn->query($sql)) {
		// Handle query execution error
		echo $conn->error;
	} else {
		// If the query is successful, redirect to a specified location
		header("Location: http://localhost/awlr/api/user/");
		// Note: You might want to use an absolute URL or a dynamic URL to make the code more flexible.
		// For example, construct the URL based on the server environment or configuration.
	}
}
