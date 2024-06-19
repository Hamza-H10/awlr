<?php
// Include the database connection file
require_once("../dbcon.php");

// Initialize an empty string to store HTML content
$htm = '';

// Check if the GET parameters are set
if ($_GET) {
  // Sanitize the device ID from the GET parameters
  $device_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

  // SQL query to retrieve device data based on the device ID
  $sql = "SELECT *, device_data.id AS ddid FROM device_data
          LEFT JOIN devices ON devices.id = device_data.device_id
          WHERE device_data.device_id=" . $device_id . " ORDER BY date_time DESC";

  // Initialize an array to store device data
  $details = array();

  // Execute the SQL query
  if (!$result = $conn->query($sql)) {
    echo $conn->error;
  } else {
    while ($rows = $result->fetch_assoc()) {
      $details[] = $rows;
    }
  }

  // Build the HTML table with device data
  $htm .= '<table class="table table-bordered table-hover" id="example">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>Date & Time</th>
                <th>Value</th>
                <th>Unit</th>
                <th>Temp (deg C)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
  $i = 1;
  foreach ($details as $key) {
    $htm .= '<tr>';
    $htm .= '<td>' . $i . '</td>';
    $htm .= '<td>' . $key['date_time'] . '</td>';
    $htm .= '<td>' . $key['value1'] . '</td>';
    $htm .= '<td>' . $key['value2'] . '</td>';
    $htm .= '<td>' . $key['value3'] . '</td>';
    $htm .= '<td><a class="btn btn-danger delancid" id="' . $key['ddid'] . '" href="javascript:void(0)">Delete</a></td>';
    $htm .= '</tr>';
    $i++;
  }
}
$htm .= ' </tbody>
          </table>';
echo $htm;
?>

<!-- JavaScript code for DataTable initialization and delete action -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'csv', 'excel',
        {
          text: 'Graph',
          action: function(e, dt, button, config) {
            // Add your custom action for the Graph button here
            // alert('Graph button clicked!');
            var device_id = <?= $device_id ?>;
            window.location.href = "graph_index.php?d_id=" + device_id;
          }
        }
      ]
    });

    $(".delancid").click(function() {
      var id = $(this).attr("id")
      if (confirm('Are You sure?')) {
        // AJAX request to delete device data based on the device data ID
        $.ajax({
          type: "GET",
          url: "deletedevicedata.php?id=" + id,
          success: function(result) {
            if (result == true) {
              $("#" + id).closest('tr').remove();
            } else {
              alert('Something went wrong!');
            }
          }
        });
      }
    });
  });
</script>