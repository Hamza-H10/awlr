<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';
include 'db_connection.php';
?>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <script>
        console.log('Before variable initialization');
        let sensors = 8;
        let depth = 5;
        let borehole = 1;
        let site = "office";
        let location = "off";
        console.log('After variable initialization');
    
    fetch('fm_api.php')
    .then(response => response.json())
    .then(data => {
        // Use the fetched data here
        console.log(data);
    })
    .catch(error => console.error('Error fetching data:', error));

   
    // Variable initializations here
   


        const labels = [];
        const today = new Date();

        for (let i = 6; i >= 0; i--) {
            const date = new Date(today);
            date.setMonth(today.getMonth() - i);
            labels.push(date.toLocaleDateString('default', {
                month: 'long'
            }));
        }
        const data = {
            labels: labels,
            datasets: [{
                axis: 'y',
                label: 'My First Dataset',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1,
                tension: 0.2
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        };

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, config);
    </script>
</body>
</html>