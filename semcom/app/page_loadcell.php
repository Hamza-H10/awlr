<style>
  .invisible {
    display: none;
  }
</style>
<div class="ui main container">
<h3>Graph</h3>
<div class="ui selection dropdown">
  <input type="hidden" name="slave" value="11">
  <i class="dropdown icon"></i>
  <div class="default text">Select Slave</div>
  <div class="menu">
    <div class="item" data-value="11">Slave 4</div>
    <div class="item" data-value="14">Slave 5</div>
    <div class="item" data-value="17">Slave 6</div>
    <div class="item" data-value="20">Slave 7</div>
    <div class="item" data-value="23">Slave 8</div>
    <div class="item" data-value="26">Slave 9</div>
    <div class="item" data-value="29">Slave 10</div>
    <div class="item" data-value="32">Slave 11</div>
    <div class="item" data-value="35">Slave 12</div>
    <div class="item" data-value="38">Slave 13</div>
    <div class="item" data-value="41">Slave 14</div>
    <div class="item" data-value="44">Slave 15</div>
    <div class="item" data-value="47">Slave 16</div>
    <div class="item" data-value="50">Slave 17</div>
    <div class="item" data-value="53">Slave 18</div>
    <div class="item" data-value="56">Slave 19</div>
    <div class="item" data-value="59">Slave 20</div>
    <div class="item" data-value="62">Slave 21</div>
    <div class="item" data-value="65">Slave 22</div>
    <div class="item" data-value="68">Slave 23</div>
    <div class="item" data-value="71">Slave 24</div>
    <div class="item" data-value="74">Slave 25</div>
    <div class="item" data-value="77">Slave 26</div>
    <div class="item" data-value="80">Slave 27</div>
    <div class="item" data-value="83">Slave 28</div>
  </div>
</div>
<canvas id="myChart"></canvas>

<!-- DATA FORM -->
<a name="table1_user_form_target"></a>

    <div class="ui horizontal divider header">Load Cell Data</div>
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
  <script>
    var table1= new Tabulation({
            apiUrl: "<?=$app_root?>/api/?function=vw_list&slave_no=4&channel_no=11&pgno=",
            loaderFunction: table1_generate,
            edit: false,
            delete: false,
            selectMulti: false,
            });

    $(function() {
        $('.ui.checkbox').checkbox();

        //table1.init();
        table1.loadPage(1, true, "<?=$app_root?>/api/?function=ldcell_list&slave_no=4&channel_no=11&pgno=");

    });

    $(".dropdown").dropdown({
        onChange: function (val) {
          var slave_no = 1 + Math.floor(val/3);
          var channel_no = val;
          table1.loadPage(1, true, "<?=$app_root?>/api/?function=ldcell_list&slave_no="+slave_no+"&channel_no="+channel_no+"&pgno=");

        }
    });

    var colorData = ["#708090","#BC8F8F","#8B4513","#DB7093","#800080","#483D8B","#1E90FF","#5F9EA0","#48D1CC","#008B8B","#DAA520","#FF8C00","#5F9EA0","#CD5C5C",
        "#A52A2A","#B8860B","#4682B4","#8B008B","#A0522D","#556B2F","#6B8E23","#20B2AA","#4169E1","#483D8B","#4B0082","#DB7093","#2F4F4F","#66CDAA","#DB7093","#FF9933"];

    var ctx = document.getElementById('myChart').getContext('2d');
    var chartData = {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: null,
            datasets: [{
                label: 'Data',
                backgroundColor: '#D5A364',
                borderColor: '#B22222',
                borderWidth: 0,            
                data: null,
                fill: false,
            }]
        },
        

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                      beginAtZero : true
                    },
                    display: true,
                    scaleLabel: {
                      display: true,
                      fontStyle: 'bold',
                      labelString: 'Load (Ton)'
                    }
                }]
            }
        }
    };
    var chart = new Chart(ctx, chartData);

    function table1_export() {

      var val = $("input[name='slave']").val();
      var slave_no = 1 + Math.floor(val/3);
      var channel_no = val;

      var access_url = "<?=$app_root?>/api/?function=ldcell_list&slave_no="+slave_no+"&channel_no="+channel_no+"&pgno=0";

      var config = {
        filename: 'loadcell-data-log',
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
        chart.data.labels = new Array(30);
        chart.data.datasets[0].data = new Array(30);
        chart.data.datasets[0].backgroundColor = new Array(30);
        //chart.data.datasets[0].label = "This is my new label";

        var table_output = "<table class='ui celled table'><thead><tr>" + 
                    "<th class='center aligned'>Slave No</th>" +
                    "<th class='right aligned'>Engg. Unit (Ton)</th>" +
                    "<th class='center aligned'>Record Time</th>" +
                    "<th>Remarks</th>" +
                    "</tr></thead><tbody>";
        if(!myObj) {
            chart.update();
            table_output += "<td class='center aligned' colspan='4'>No records found</td></tr></table>";
            return(table_output);
        }

        $.each(myObj.records, function (val) {
            
            table_output += "<tr" + className + ">";
            
            table_output += "<td class='center aligned'>"+myObj.records[val].slave_no+"</td>";
            table_output += "<td class='right aligned'>"+parseFloat(myObj.records[val].data).toFixed(2)+"</td>";
            table_output += "<td class='center aligned'>"+myObj.records[val].record_time+"</td>";
            table_output += "<td>"+myObj.records[val].remarks+"</td>";
            table_output += "</tr>";

            chartData.data.labels[cnt] = myObj.records[val].record_time;
            chartData.data.datasets[0].data[cnt] = parseFloat(myObj.records[val].data).toFixed(2);
            chartData.data.datasets[0].backgroundColor[cnt] = colorData[cnt];
            cnt++;

        });
        table_output += "</tbody></table>";

        chart.update();
        return(table_output);
    }

  </script>
</body>  
</html>
