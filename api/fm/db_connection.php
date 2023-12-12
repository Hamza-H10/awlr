<?php

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

date_default_timezone_set('Asia/Kolkata');

?>
