<?php
    require_once './app/model/db.php';
    $database = new Database();

    $ic = $pc = $lc = 0;
    // In-place count
    $stmt = $database->execute("SELECT Count(DISTINCT slave_no) as total FROM `inplace_dd` WHERE record_time > now() - interval 1 day");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ic = $row["total"];
    }

    // Piezo meter count
    $database->execute("SELECT Count(DISTINCT slave_no) as total FROM `vwire_dd` WHERE slave_no <= 3 AND record_time > now() - interval 1 day");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pc = $row["total"];
    }

    // Load cell count
    $database->execute("SELECT Count(DISTINCT slave_no) as total FROM `vwire_dd` WHERE slave_no > 3 AND record_time > now() - interval 1 day");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lc = $row["total"];
    }

?>
<div class="ui main container">
<h3>Activity Stats</h3>
<table class="ui celled table">
  <thead>
    <tr><th></th>
    <th class="center aligned">Total</th>
    <th class="center aligned">Active</th>
    <th class="center aligned">In-Active</th>
  </tr></thead>
  <tbody>
    <tr>
      <td class="center aligned" data-label="Name">Piezometer</td>
      <td class="center aligned" data-label="Total">3</td>
      <td class="center aligned" data-label="Active"><?=$pc;?></td>
      <td class="center aligned" data-label="In-Active"><?=(3-$pc);?></td>
    </tr>
    <tr>
      <td class="center aligned" data-label="Name">Loadcell</td>
      <td class="center aligned" data-label="Total">25</td>
      <td class="center aligned" data-label="Active"><?=$lc;?></td>
      <td class="center aligned" data-label="In-Active"><?=(25-$lc);?></td>
    </tr>
    <tr>
      <td class="center aligned" data-label="Name">Inclinometer</td>
      <td class="center aligned" data-label="Total">7</td>
      <td class="center aligned" data-label="Active"><?=$ic;?></td>
      <td class="center aligned" data-label="In-Active"><?=(7-$ic);?></td>
    </tr>
  </tbody>
</table>
<h3>Upload CSV Data</h3>

<form method="POST" enctype="multipart/form-data" id="fileUploadForm">
   <div class="ui action input">
     <input type="file" id="csvfile" name="csvfile" accept=".csv">
     <button type="submit" class="ui icon button" id="btnSubmit">
       <i class="attach icon"></i>
     </button> &nbsp; &nbsp; &nbsp;
     <div class="ui inline loader" id="actloader"></div>
   </div>
</form>

<h3>Result</h3>
<hr>
<ul id="result"></ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {

    $("#btnSubmit").click(function (event) {

        //stop submit the form, we will post it manually.
        event.preventDefault();
        var file = document.getElementById("csvfile");
        if (file.value == "") {
           alert("No CSV file selected for upload!");
           return;
        }
        // Get form
        var form = $('#fileUploadForm')[0];

		// Create an FormData object 
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
        data.append("CustomField", "This is some extra data, testing");

		// disabled the submit button
        $("#btnSubmit").prop("disabled", true);
        var current = document.getElementById("actloader");
        current.classList.add('active')

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/semcom/api/fileupload.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var current = document.getElementById("actloader");

                $("#result").html(data);
                console.log("SUCCESS : ", data);
                $("#btnSubmit").prop("disabled", false);
                current.classList.remove('active')
            },
            error: function (e) {
                var current = document.getElementById("actloader");

                $("#result").html(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);
                current.classList.remove('active')

            }
        });

    });

});


</script>
