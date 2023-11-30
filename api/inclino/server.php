<?php
// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming data is sent as JSON
    $postData = json_decode(file_get_contents("php://input"), true);

    // Process the received data
    if (!empty($postData)) {
        // You can perform any processing with the received data here
        // For simplicity, let's store it in a session variable
        session_start();
        $_SESSION['receivedData'] = $postData;
        echo "Data received successfully!";
    } else {
        echo "No data received!";
    }
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve data from the session variable (you can use a database for persistence)
    session_start();
    $receivedData = isset($_SESSION['receivedData']) ? $_SESSION['receivedData'] : null;

    // Display the received data on the webpage
    if (!empty($receivedData)) {
        echo '<h2>Received Data:</h2>';
        echo '<pre>';
        print_r($receivedData);
        echo '</pre>';
    } else {
        echo '<p>No data received yet.</p>';
    }
}
?>
