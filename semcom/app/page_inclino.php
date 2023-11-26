<style>
  .invisible {
    display: none;
  }
</style>
<link href="css/datepicker.min.css" rel="stylesheet" type="text/css">

<div class="ui main container">
<div class="ui form">
  <div class="inline fields">
    <div class="field">
      <div class="ui selection dropdown">
        <input type="hidden" name="slave" value="29">
        <i class="dropdown icon"></i>
        <div class="default text">Select Node</div>
        <div class="menu">
          <div class="item" data-value="29">Node 29</div>
          <div class="item" data-value="30">Node 30</div>
          <div class="item" data-value="31">Node 31</div>
          <div class="item" data-value="32">Node 32</div>
          <div class="item" data-value="33">Node 33</div>
          <div class="item" data-value="34">Node 34</div>
          <div class="item" data-value="35">Node 35</div>
        </div>
      </div>
    </div>
    <div class="field">
      <label>Channel </label>
      <div class="ui radio checkbox">
        <input type="radio" name="channel" value="x" checked="checked">
        <label>X &nbsp;&nbsp;</label>
      </div>
      <div class="ui radio checkbox">
        <input type="radio" name="channel" value="y">
        <label>Y</label>
      </div>
    </div>
    <div class="field">
    </div>
    <div class="field">
      <label>Select dates for graph</label>
      <div class="ui action input">
        <input type="text" class="datepicker-here" data-language='en' data-multiple-dates="5"
          data-multiple-dates-separator=", " data-position='bottom left' name="date_text" />
        <div class="ui red small button" onclick="$('input[name=\'date_text\']').val('');dateFilter();">
        <i class="trash icon"></i> Clear
        </div>
      </div>
    </div>
  </div>
</div>
<canvas id="myChart"></canvas>
<h3 class="ui header" id="project_name">
  UJVNL VYASI HEP 120MW
  <div class="sub header" id="sub_title">Sub Header</div>
  <div class="sub header" id="node_number">Node No: </div>
  
  <div class="sub header" id="install_location">Location: </div>
  <div class="sub header" id="install_date">03-Sept-2019</div>
  <div class="sub header" id="initial_reading">Dat4e</div>
</h3>
<!-- DATA FORM -->
<a name="table1_user_form_target"></a>

    <div class="ui horizontal divider header">Inclino Data</div>
  <!-- DATA LIST -->

    <div class="ui grid ">
      <div class="eleven wide column">
        <!-- <h2 class="ui header">User List</h2> -->
        <button class="ui circular green icon button" id="table1_export" onclick="table1_export()" >
          <i class="table icon"></i>
        </button>

      </div>
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
  <script src="js/chart.min.js"></script>
  <script src="js/standalone.js"></script>

  <script src="js/datepicker.min.js"></script>

  <!-- Include English language -->
  <script src="js/i18n/datepicker.en.js"></script>

  <script>
    var table1= new Tabulation({
            apiUrl: "<?=$app_root?>/api/?function=incl_list&slave_no=29&pgno=",
            loaderFunction: table1_generate,
            edit: false,
            delete: false,
            selectMulti: false,
            });

    $(function() {
        //$('.ui.checkbox').checkbox();
        $('.ui.checkbox').checkbox({
          onChecked: function() {
            dateFilter();
          },
        });
        $('input[name=\'date_text\']').datepicker({onSelect:dateFilter});

        //table1.init();
        table1.loadPage(1, true, "<?=$app_root?>/api/?function=incl_list&slave_no=29&channel=x&pgno=");

    });

    $(".dropdown").dropdown({
        onChange: function (val) {
          dateFilter();
        }
    });

    function dateFilter() {
        var search_text = $("input[name='date_text']").val();
        var channel = $("input[name='channel']:checked").val();
        var val = $("input[name='slave']").val();
        search_text = search_text.replace(/ /g,'');

        table1.loadPage(1, true, "<?=$app_root?>/api/?function=incl_list&slave_no="+val+"&channel="+channel+"&date_filter="+search_text+"&pgno=");
    }

    var colorData = ["#708090","#BC8F8F","#8B4513","#DB7093","#800080","#483D8B","#1E90FF","#5F9EA0","#48D1CC","#008B8B","#DAA520","#FF8C00","#5F9EA0","#CD5C5C",
        "#A52A2A","#B8860B","#4682B4","#8B008B","#A0522D","#556B2F","#6B8E23","#20B2AA","#4169E1","#483D8B","#4B0082","#DB7093","#2F4F4F","#66CDAA","#DB7093","#FF9933"];

    var ctx = document.getElementById('myChart').getContext('2d');
    var chartData = {
        type: 'scatter',
        data: {
            datasets: [{},{},{},{},{},{},{},{},{},{}]
        },
        options: {
            legend: {
                position:'right'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    display: true,
                    scaleLabel: {
                      display: true,
                      fontStyle: 'bold',
                      labelString: 'Probe Depth (Mtr)'
                    }
                }],
                xAxes: [{
                    type: 'linear',
                    position: 'bottom',
                    display: true,
                    scaleLabel: {
                      display: true,
                      fontStyle: 'bold',
                      labelString: 'Displacement (mm)'
                    },
                    ticks: {
                        min: -100,
                        max: 100
                    }

                }]
            }
        }
    };
    var myChart = new Chart(ctx, chartData);

    function table1_export() {

      var search_text = $("input[name='date_text']").val();
      var channel = $("input[name='channel']:checked").val();
      var val = $("input[name='slave']").val();
      search_text = search_text.replace(/ /g,'');

      var access_url = "<?=$app_root?>/api/?function=incl_list&slave_no="+val+"&channel="+channel+"&date_filter="+search_text+"&pgno=0";

      var config = {
        filename: 'inclino-data-log',
        sheet: {
            data: [
                []
            ]
        }
      };
      $.get(access_url, function(data, status) {
        var myObj = JSON.parse(data);
        var cnt = 1;

        var key_names = Object.keys(myObj.records[0]);
        config.sheet.data[0] = new Array(key_names.length);
        for(var ai = 0; ai < key_names.length; ai++) {
          config.sheet.data[0][ai] = {value: key_names[ai].replace('_', ' ').ucwords(), type: "string"};
        }

        $.each(myObj.records, function (val) {

          config.sheet.data[cnt] = new Array(key_names.length);
          for(var inx = 0; inx < key_names.length; inx++) {
              config.sheet.data[cnt][inx] = {value: (myObj.records[val][key_names[inx]]?myObj.records[val][key_names[inx]]:""), type: "number"};
          }
          cnt++;
        });
        zipcelx(config);
      });

    }
    
    function table1_generate(myObj, self_prefix) {
        var className = '';
        var cnt = 0;
        var channel = $("input[name='channel']:checked").val();

        var key_names;
        var className = ''; 
        var table_output = "<table class='ui celled compact striped brown table'><thead><tr>";
        myChart.data.datasets = [{}];

        if(!myObj) {
            myChart.update();
            table_output += "<td class='center aligned'>No records found</td></tr></table>";
            return(table_output);
        }
        if(myObj.records.length > 0) {
            //$("#project_name").html(myObj.header.project_name);
            $("#sub_title").html(myObj.header.sub_title);
            $("#node_number").html("Node No: "+myObj.header.node_number);
            $("#install_location").html("Location: "+myObj.header.install_location);
            $("#install_date").html("Date of Installation: "+myObj.header.install_date);
            $("#initial_reading").html("Date of Initial Reading: "+myObj.header.initial_reading);
            key_names = Object.keys(myObj.records[0]);
            for(var ai = 0; ai < key_names.length; ai++) {
                if(myObj.text_align)
                    className = " class='"+myObj.text_align[ai]+" aligned'";

                table_output += "<th"+className+">" + key_names[ai].replace('_', ' ').ucwords() + "</th>";
            }
        }
        $.each(myObj.records, function (val) {
            myChart.data.datasets[cnt] = {
                label: myObj.records[val].record_time,
                data: null,
                showLine: true,
                borderColor: colorData[cnt],
                backgroundColor: colorData[cnt],
                borderWidth: 1,
                fill: false
            };
          
            if(channel == "x") {
                myChart.data.datasets[cnt].data = [
                  {x: myObj.records[val].x1, y: myObj.depth[0]}, 
                  {x: myObj.records[val].x2, y: myObj.depth[1]},
                  {x: myObj.records[val].x3, y: myObj.depth[2]},
                  {x: myObj.records[val].x4, y: myObj.depth[3]},
                  {x: myObj.records[val].x5, y: myObj.depth[4]},
                  {x: myObj.records[val].x6, y: myObj.depth[5]},
                  {x: myObj.records[val].x7, y: myObj.depth[6]}
                ];
            }
            else{
                myChart.data.datasets[cnt].data = [
                  {x:parseFloat(myObj.records[val].y1).toFixed(2), y: myObj.depth[0]}, 
                  {x:parseFloat(myObj.records[val].y2).toFixed(2), y: myObj.depth[1]},
                  {x:parseFloat(myObj.records[val].y3).toFixed(2), y: myObj.depth[2]},
                  {x:parseFloat(myObj.records[val].y4).toFixed(2), y: myObj.depth[3]},
                  {x:parseFloat(myObj.records[val].y5).toFixed(2), y: myObj.depth[4]},
                  {x:parseFloat(myObj.records[val].y6).toFixed(2), y: myObj.depth[5]},
                  {x:parseFloat(myObj.records[val].y7).toFixed(2), y: myObj.depth[6]}
                ];
            }
            
            className = ''; 
                        
            table_output += "<tr>";
            
            for(var inx = 0; inx < key_names.length; inx++) {
                if(myObj.text_align)
                    className = " class='"+myObj.text_align[inx]+" aligned'";
                table_output += "<td"+className+">"+(myObj.records[val][key_names[inx]]?myObj.records[val][key_names[inx]]:myObj.records[val][key_names[inx]])+"</td>";
            }
            table_output += "</tr>";

            cnt++;

        });
        table_output += "</tbody></table>";

        myChart.update();
        return(table_output);
    }

  </script>
</body>  
</html>
