<?php
session_start();
require_once("../dbcon.php");
if (!isset($_SESSION['user_session'])) {
  // header("Location: http://awlr.in/index.php");
  header("Location: http://localhost/awlr/index.php");
} elseif (!isset($_SESSION['url']) and $_SESSION['url'] == $default_url_set) {
  // header("Location: http://awlr.in/index.php");
  header("Location: http://localhost/awlr/index.php");
}
$sql = "select * from devices";
$details = array();
$row = array();
$user = array();
if (!$result = $conn->query($sql)) {
  echo $conn->error;
} else {
  while ($rows = $result->fetch_assoc()) {
    $details[] = $rows;
  }
}
$sql = "SELECT * FROM tbl_users WHERE user_id=" . $_SESSION['user_session'];
if (!$result = $conn->query($sql)) {
  echo $conn->error;
} else {
  while ($rows = $result->fetch_assoc()) {
    $row[] = $rows;
  }
}
if ($row[0]['role'] != 1) {
  // header("Location: http://awlr.in/dashboard.php");
  header("Location: http://localhost/awlr/dashboard.php");
}

$sql = "SELECT user_id,user_name FROM tbl_users WHERE user_id!=" . $_SESSION['user_session'];
if (!$result = $conn->query($sql)) {
  echo $conn->error;
} else {
  while ($rows = $result->fetch_assoc()) {
    $user[] = $rows;
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
    <h2 class="text-center">Devices</h2>
    TESTING INCLINO
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <?php if ($row[0]['role'] != '0') { ?>
                <div class="col-md-4">
                  <a class="btn btn-success" href="adddevice.php"><span>Add Device</span></a>
                </div>
              <?php } ?>
              <div class="col-md-4">
                <?php if ($row[0]['role'] != '0') { ?>
                  <a class="btn btn-primary" href="devices_data.php"><span>Data List</span></a>
                <?php } else { ?>
                  <a class="btn btn-primary" href="devices_data.php"><span>Data List</span></a>
                <?php } ?>
              </div>
              <div class="col-md-2">
                <!-- for admin -->
                <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Hi <?php echo $row[0]['user_name']; ?>
                    <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a tabindex="-1" href="<?= $_SESSION['url'] ?>logout.php">Sign Out</a></li>
                  </ul>
                </div>
                <!-- for admin -->
              </div>
              <div class="col-md-2 pull-right">
                <a href="<?= $_SESSION['url'] ?>dashboard.php"><button class="btn btn-danger" type="button">Back</button></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-4 col-md-offset-4" id="succalert" style="display: none;">
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Congrats!</strong> User alloted successfully.
          </div>
        </div>
        <div class="col-md-4 col-md-offset-4" id="erroralert" style="display: none;">
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Oops!</strong> Something is wrong.
          </div>
        </div>
      </div>

      <table class="table table-bordered table-hover display nowrap" id="myTable" class="" style="width:100%">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Name</th>
            <th>Number</th>
            <th>Alloted User</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          foreach ($details as $key) { ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $key['device_short_name'] ?></td>
              <td><?= $key['device_number'] ?></td>
              <td>
                <select class="form-control user" data-device="<?= $key['id'] ?>">
                  <option value="0">Select User</option>
                  <?php if (isset($user) && !empty($user)) {
                    foreach ($user as $key1) { ?>
                      <option value="<?= $key1['user_id'] ?>" <?= $key1['user_id'] == $key['user_id'] ? 'selected' : '' ?>><?= $key1['user_name'] ?></option>
                  <?php }
                  } ?>
                </select>
              </td>
              <td><a class="btn btn-info" href="updatedevice.php?id=<?= $key['id'] ?>">Update</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="return confirm('Are You sure?')" href="deletedevices.php?id=<?= $key['id'] ?>">Delete</a></td>
            </tr>
          <?php $i++;
          } ?>
        </tbody>
      </table>
    </div>
  </div>
  </div>
</body>
<script type="text/javascript">
  $(document).ready(function() {

    $('.user').change(function() {
      var userid = $(this).val();
      var deviceid = $(this).data('device');
      $.ajax({
        type: "GET",
        url: "action.php?action=updatedevice&user=" + userid + "&device=" + deviceid,
        success: function(result) {
          if (result) {
            $("#succalert").show();
            $("#succalert").fadeOut(3000);
          } else {
            $("#erroralert").show();
            $("#erroralert").fadeOut(3000);
          }
        }
      })
    });

    $('#myTable').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'csv', 'excel'
      ]
    });
  });
</script>

</html>