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
        echo json_encode(["message" => "Data received successfully!"]);
        exit; // Ensure no HTML content is added after echoing JSON
    } else {
        echo json_encode(["error" => "No data received!"]);
        exit;
    }
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve data from the session variable (you can use a database for persistence)
    session_start();
    $receivedData = isset($_SESSION['receivedData']) ? $_SESSION['receivedData'] : null;

    // Display the received data on the webpage
    header('Content-Type: application/json'); // Set content type to JSON
    echo json_encode($receivedData);
    exit;
}
