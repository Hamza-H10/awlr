<!DOCTYPE html>
<html>

<head>
    <title>Get and display JSON Data</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <style>
        .cwhite {
            color: #FFFFFF
        }
    </style>
    <script>
        function fetchAndDisplayData() {
            fetch('https://api.thingspeak.com/channels/2345726/feeds.json?results=2').then(res => {
                    // console.log(res);
                    return res.json();
                })
                .then(data => {
                    // console.log(data);
                    data.forEach(user => {
                        const markup = '<li>${user.name}</li>';

                        document.querySelector('ul').insertAdjacentHTML(
                            'beforeend', markup);
                    });
                })
                .catch(error => console.log(error));
        }
    </script>

</head>

<body onload="fetchAndDisplayData()"> <!-- Your PHP code will go here -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
</body>

</html>