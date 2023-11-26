 <?php
$servername = "localhost";
$username = "alwr_admin";
$password = "admin@123";
$dbName = "site_alwr";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?> 