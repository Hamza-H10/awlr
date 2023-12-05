<?php
// Start a session to manage user sessions
session_start();
$session_user_id = 0;

// Check if a user session is active and set the user ID
if (isset($_SESSION['user_session']))
  $session_user_id = $_SESSION['user_session'];

// Include the database connection file
require_once("../dbcon.php");

// Initialize arrays to store user details and device details
$row = array();
$details = array();

// Fetch user details from the database based on the user ID
$sql = "SELECT * FROM tbl_users WHERE user_id=" . $session_user_id;
if (!$result = $conn->query($sql)) {
  echo $conn->error;
} else {
  while ($rows = $result->fetch_assoc()) {
    $row[] = $rows;
  }
}

// Determine the SQL query based on the user's role
if ($row[0]['role'] == 1) {
  $sql = "select * from devices";
} else {
  $sql = "select * from devices where user_id=" . $session_user_id;
}

// Fetch device details based on the SQL query
if (!$result = $conn->query($sql)) {
  echo $conn->error;
} else {
  while ($rows = $result->fetch_assoc()) {
    $details[] = $rows;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

  <!-- Export JS libraries -->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Export JS libraries -->

</head>

<body>

  <div class="container">
    <h2 class="text-center">Device Data</h2>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-8">
            <!-- Dropdown to select device name -->
            <div class="form-group">
              <select name="device" class="form-control" id="dvcname">
                <option value="0">Select Device Name</option>
                <?php foreach ($details as $key) { ?>
                  <!-- Display device names in the dropdown -->
                  <option value="<?= $key['id'] ?>"><?= $key['device_short_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4"><a class="btn btn-danger pull-right" href="index.php"><span>Back</span></a> </div>
        </div>
      </div>

      <div class="panel-body" id="tbldevicediv">
        <!-- Placeholder for device data table -->
      </div>

    </div>
  </div>

</body>

<script>
  $(document).ready(function() {
    // Event handler for device name dropdown change
    $("#dvcname").change(function() {
      var id = $('#dvcname').find(":selected").val();
      // AJAX request to get device data based on the selected device
      $.ajax({
        type: "GET",
        url: "fm_getdevicesdatabyid.php?id=" + id,
        success: function(result) {
          // Display the retrieved device data
          $("#tbldevicediv").html(result);
        }
      });
    })
  });
</script>

</html>