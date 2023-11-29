<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api testing</title>
</head>

<body>

    <h1>Requests made</h1>

    <button id="postDataBtn">Send Post</button>

    <h2>Received Data:</h2>
    <pre id="receivedData"></pre>

    <script>
        // Function to make a POST request
        function sendPostRequest() {
            // Assuming data to send
            const postData = {
                message: 'Hello from the client!'
            };

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
                    // Reload the page to fetch and display the updated data
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        }

        // Attach the function to the button click event
        document.getElementById('postDataBtn').addEventListener('click', sendPostRequest);

        // Make a GET request to retrieve and display the data
        fetch('server.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('receivedData').innerText = data;
            })
            .catch(error => console.error('Error:', error));
    </script>

</body>

</html>