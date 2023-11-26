<style>
  .invisible {
    display: none;
  }
</style>
<div class="ui main container">

<!-- DATA FORM -->
    <div class="ui horizontal divider header">Device List</div>
  <!-- DATA LIST -->

    <div class="ui grid ">
      <div class="five wide column right floated right aligned">
        <div class="ui icon input">
          <input type="text" placeholder="Search..." id="table1_search">
          <i class="circular delete link icon" id="table1_clear_btn"></i>
          <i class="inverted circular search link icon" id="table1_search_btn"></i>
        </div>        
      </div>
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
            apiUrl: "<?=$app_root?>/api/?function=device_list&pgno=",
            fetchUrl:"<?=$app_root?>/api/?function=user_fetch&row_id=",
            selectMulti: false, edit: false, delete: false
            });

    $(function() {
        $('.selection.dropdown').dropdown();
        $('.ui.checkbox').checkbox();

        //table1.init();
        table1.loadPage(1, true);

    });
  </script>
</body>  
</html>
