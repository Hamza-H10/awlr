<?php 
  $database = new Database();

  $device_id = getValue("device_id", false, 163);

  $stmt = $database->execute("SELECT device_number, device_short_name from devices where id = $device_id");
  $num = $stmt->rowCount();
  
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $device_number = $row['device_number'];
    $device_name = $row['device_short_name'];
  }
?>
<style>
  .invisible {
    display: none;
  }
</style>
<div class="ui main container">

<!-- DATA FORM -->
    <div class="ui selection dropdown">
      <input type="hidden" name="slave" value="0">
      <i class="dropdown icon"></i>
      <div class="default text">Select Sensor</div>
      <div class="menu">
        <div class="item" data-value="0">All</div>
        <div class="item" data-value="1">Sensor 1</div>
        <div class="item" data-value="2">Sensor 2</div>
        <div class="item" data-value="3">Sensor 3</div>
        <div class="item" data-value="4">Sensor 4</div>
      </div>
    </div>

    <div class="ui horizontal divider header">Device Data</div>
  <!-- DATA LIST -->
  <div class="ui grid ">
    <div class="three wide column">
      <h4>Site ID: 4E-00</h4>
      <h4>Site Name: India</h4>
    </div>
    <div class="thirteen wide column">
      <h4>Sensor ID: <?php echo $device_number; ?></h4>
      <h4>BMRCL Metro Segments - <?php echo $device_name; ?></h4>
    </div>
  </div>

    <div class="ui grid ">
      <div id="table1_datawindow" class="table_datawindow"></div>
      <!-- <div class="content" id="info"></div> -->
      <div id="table1_pagination" class="eleven wide column"></div>
      <div class="five wide column right floated right aligned">
        <h4 class="ui right floated">
          <div class="content" id="table1_info"></div>
        </h4>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/semantic.min.js"></script>
  <script src="js/pagination.js"></script>
  <script src="js/tabulation.js"></script>
  <script>
    var table1= new Tabulation({
            apiUrl: "<?=$app_root?>/api/?function=device_data&device_id=<?php echo $device_id; ?>&sensor_no=0&pgno=",
            fetchUrl:"<?=$app_root?>/api/?function=user_fetch&row_id=",
            selectMulti: false, edit: false, delete: false
            });

    $(function() {
        $('.selection.dropdown').dropdown({
            onChange: function (val) {
              table1.loadPage(1, true, "<?=$app_root?>/api/?function=device_data&device_id=<?php echo $device_id; ?>&sensor_no="+val+"&pgno=");

            }
        });
        $('.ui.checkbox').checkbox();

        //table1.init();
        table1.loadPage(1, true);

    });
  </script>
</body>  
</html>
