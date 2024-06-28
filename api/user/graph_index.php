<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


// include("menu.php");
//index.php
$d_id = isset($_GET['d_id']) ? $_GET['d_id'] : null;

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- DataTables Bootstrap CSS -->
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Date Range Picker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <!-- <script src="library/Chart.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <!-- jQuery DataTables -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    <!--chart.js library will be included here befor the chartjs-plugin-datalabels -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>


    <title>AWLR Device Graph and Records View</title>
</head>

<style>
    .card {
        border: 1px solid teal;
        background-color: lightblue;

        /* Set background color */
        padding: 5px;
        /* Add padding to create space between border and content */
    }

    #refreshButton {
        background-color: lightblue;
        color: black;
        transition: background-color 0.3s;
        /* Add smooth transition effect */
    }

    #refreshButton:hover {
        background-color: steelblue;
        color: white;
    }
</style>

<body>

    <div class="container-fluid">
        <h1 class="mt-2 mb-3 text-center text-primary"> </h1>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-9"> <!-- Adjust column size as needed -->
                        <strong> Data Device </strong>

                        <button id="refreshButton" class="btn btn-secondary ms-auto float-end">Chart Reload</button>
                    </div>
                    <div class="col col-sm-3">
                        <input type="text" id="daterange_textbox" class="form-control" readonly />
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="chart-container pie-chart">
                        <canvas id="bar_chart" height="60"> </canvas>
                    </div>
                    <table class="table table-striped table-bordered" id="order_table">
                        <thead>
                            <tr>
                                <th>Value</th>
                                <th>Unit</th>
                                <th>Temperature</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>

</script>

<script>
    $(document).ready(function() {

        // Register the plugin to all charts:
        // Chart.register(ChartDataLabels);

        var d_id = "<?php echo $d_id; ?>";

        fetch_data('', '', d_id); // Pass d_id when calling fetch_data
        // fetch_data();

        var sale_chart;

        function fetch_data(start_date = '', end_date = '', d_id = '') {
            var dataTable = $('#order_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "graph_action.php",
                    // url: "app\action.php",
                    type: "POST",
                    data: {
                        action: 'fetch',
                        start_date: start_date,
                        end_date: end_date,
                        d_id: d_id
                    }
                },
                dataSrc: function(response) {
                    try {
                        // Parse the response to a JavaScript object
                        var data = JSON.parse(response);

                        // Log each element of the data array
                        data.data.forEach(function(record) {
                            console.log(record);
                        });

                        // Return the data property for DataTables to display
                        return data.data;
                    } catch (error) {
                        console.error("Error parsing response:", error);
                        return [];
                    }
                },
                "drawCallback": function(settings) {
                    var date = [];
                    var values = [];
                    // var value = [];
                    var values_diff = [];

                    for (var count = 0; count < settings.aoData.length; count++) {
                        date.push(settings.aoData[count]._aData[3]); //settings.aoData[count] is an array of objects that contains the data for the sales.
                        values.push(parseFloat(settings.aoData[count]._aData[0]));
                        // flowrate.push(parseFloat(settings.aoData[count]._aDate[0]));
                    }

                    // Calculate the differences between consecutive elements in the values array
                    for (var i = 0; i < values.length - 1; i++) {
                        // for (var i = 0; i <= values.length; i++) {
                        var nextSale = values[i + 1] !== undefined ? values[i + 1] : 0;
                        var diff = values[i] - nextSale;
                        // var diff = values[i] - values[i + 1];

                        // values_diff.push(values[i] - values[i + 1]);
                        values_diff.push(diff < 0 ? 0 : diff);
                    }

                    // Update the original values array with the differences
                    // for (var j = 0; j < values_diff.length; j++) {
                    //     values[j] = values_diff[j];
                    // }

                    // Remove the last element from the original values array
                    // values.pop();
                    // date.pop();

                    var formattedValues = values.map(function(value) {


                        return parseFloat(value).toFixed(2);
                    });

                    var chart_data = {
                        labels: date, //lables for the x-axis
                        datasets: [{
                            label: 'value',
                            // backgroundColor: 'rgb(255, 205, 86)',
                            // backgroundColor: 'rgba(127,255,212,0.5)',

                            backgroundColor: 'rgba(0,128,128,0.65)',
                            // backgroundColor: 'rgba(0,0,139,0.65)',

                            // backgroundColor: 'rgb(106, 156, 168)',
                            borderColor: 'rgba(127,250,212,10)',
                            color: '#fff',
                            data: formattedValues,
                            // data: values_diff,
                            borderWidth: 1,
                            datalabels: {
                                color: 'black',
                                // color: 'darkblue',
                                // color: borderColor,
                                anchor: 'end',
                                align: 'top',
                                offset: '5',
                                // font: 'bold'
                                // backgroundColor: 'rgba(0,191,255,0.2)',

                                backgroundColor: 'rgba(102,178,178,0.5)',
                                // backgroundColor: 'rgba(135,206,235,0.8)',
                                borderColor: 'rgba(127,255,212,5)',
                                // borderWidth: 1,
                                borderRadius: 5,
                                font: {
                                    weight: 'bold',
                                    size: 9
                                }
                            }
                        }]
                    };

                    var group_chart3 = $('#bar_chart');

                    if (sale_chart) {
                        sale_chart.destroy();
                    }

                    sale_chart = new Chart(group_chart3, {
                        type: 'bar',
                        data: chart_data,
                        // datalables: {
                        //     color: 'blue'
                        // },

                        plugins: [ChartDataLabels],
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true, // Start the y-axis from 0
                                        // You can customize other tick settings here, such as stepSize, min, max, etc.
                                        // stepSize: 50,
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        font: {
                                            size: 12 // Adjust the font size as needed
                                        }
                                    }
                                }]
                            }
                        },
                        // plugins: {
                        //     datalabels: {
                        //         anchor: 'end',
                        //         align: 'top',
                        //         formatter: function(value, context) {
                        //             return value;
                        //         }
                        //     }
                        // }

                    });
                }
            });
        }

        $('#daterange_textbox').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            format: 'YYYY-MM-DD'
        }, function(start, end) {

            $('#order_table').DataTable().destroy();

            fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), d_id);
        });

        $('#refreshButton').click(function() {
            // Perform data refresh or reload here
            location.reload(); // Example: Reload the page
        });
    });
</script>