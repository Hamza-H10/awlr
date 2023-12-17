<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chart.js Line Plot</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div>
    <canvas id="myChart"></canvas>
  </div>

  <script>
    function createChart() {
      // Create an array of month names for the labels
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];

      const data = {
        labels: months,
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
          borderWidth: 1
        }]
      };

      const config = {
        type: 'line',
        data: data,
        options: {
          indexAxis: 'y',
          scales: {
            x: {
              beginAtZero: true,
              type: 'linear',
              position: 'bottom',
              ticks: {
                stepSize: 5,
                callback: function(value) {
                  return value % 10 === 0 ? value : '\u200B'; // Add zero-width space for non-labeled ticks
                },
              },
              // max: 40, // Set the maximum value for the x-axis
              // min: -40, // Set the minimum value for the x-axis
              suggestedMax: 40, // Suggested maximum value for the x-axis
              suggestedMin: -40, // Suggested minimum value for the x-axis
            }
          }
        }
      };
      const ctx = document.getElementById('myChart').getContext('2d');
      new Chart(ctx, config);
    }
    // Call the createChart function
    createChart();
  </script>
</body>

</html>