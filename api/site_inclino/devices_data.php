<?php
session_start();
$session_user_id = 0;
if (isset($_SESSION['user_session']))
  $session_user_id = $_SESSION['user_session'];
require_once("dbcon.php");
$row = array();
$details = array();
$sql = "SELECT * FROM tbl_users WHERE user_id=" . $session_user_id;
// if (!$result = $conn->query($sql)) {
//   echo $conn->error;
// } else {
//   while ($rows = $result->fetch_assoc()) {
//     $row[] = $rows;
//   }
// }

// if ($row[0]['role'] == 1) {
//   $sql = "select * from devices";
// } else {
//   $sql = "select * from devices where user_id=" . $session_user_id;
// }
// if (!$result = $conn->query($sql)) {
//   echo $conn->error;
// } else {
//   while ($rows = $result->fetch_assoc()) {
//     $details[] = $rows;
//   }
// }
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
  <!-- export js -->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js "></script>
  <!-- export js -->
</head>

<body>

  <div class="container">
    <h2 class="text-center">Device Data</h2>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <select name="device" class="form-control" id="dvcname">
                <option value="0">Select Device Name</option>
                <?php foreach ($details as $key) { ?>
                  <option value="<?= $key['id'] ?>"><?= $key['device_short_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4"><a class="btn btn-danger pull-right" href="index.php"><span>Back</span></a> </div>
        </div>
      </div>

      <div class="panel-body" id="tbldevicediv">


      </div>

    </div>
  </div>

</body>
<script>
  $(document).ready(function() {
    $("#dvcname").change(function() {
      var id = $('#dvcname').find(":selected").val();
      $.ajax({
        type: "GET",
        url: "getdevicesdatabyid.php?id=" + id,
        success: function(result) {
          $("#tbldevicediv").html(result);
        }
      });
    })
  });
</script>

</html>