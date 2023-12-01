<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inclino API</title>
</head>

<body>

    <h1>Requests made</h1>

    <label for="postDataInput">Enter JSON Data:</label>
    <input type="text" id="postDataInput" placeholder='{"key": "value"}'>
    <button id="postDataBtn">Send Post</button>

    <h2>Received Data:</h2>
    <pre id="receivedData"></pre>

    <script>
        function sendPostRequest() {
            // Get the JSON input from the user
            const jsonInput = document.getElementById('postDataInput').value.trim();

            try {
                // Parse the user input as JSON
                const postData = JSON.parse(jsonInput);

                // Make a POST request using Fetch API
                fetch('server.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(postData),
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Display the response from the server

                        // Fetch and display the updated data without reloading the page
                        fetchAndDisplayData();
                    })
                    .catch(error => console.error('Error:', error));
            } catch (error) {
                console.error('Invalid JSON input:', error);
                alert('Invalid JSON input. Please enter valid JSON.');
            }
        }

        function fetchAndDisplayData() {
            // Make a GET request to retrieve and display the data
            fetch('server.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('receivedData').innerText = JSON.stringify(data, null, 2);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        document.getElementById('postDataBtn').addEventListener('click', sendPostRequest);

        // Fetch and display data when the page loads
        fetchAndDisplayData();
    </script>

</body>

</html>