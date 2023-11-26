<?php
//  include('include/header.php');
?>
<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<style>
    .cwhite {
        color: #FFFFFF
    }
</style>  -->


<head>
    <title>Get and display JSON Data</title>
</head>

<body>
    <h1>Users:</h1>
    <ul></ul>
    <script>
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
    </script>
</body>

<?php
//  include('include/footer.php');
?>