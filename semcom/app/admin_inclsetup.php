
<div class="ui main container">
    <div class="ui selection dropdown">
        <input type="hidden" name="slave" value="29">
        <i class="dropdown icon"></i>
        <div class="default text">Select Slave</div>
        <div class="menu">
            <div class="item" data-value="29">Slave 29</div>
            <div class="item" data-value="30">Slave 30</div>
            <div class="item" data-value="31">Slave 31</div>
            <div class="item" data-value="32">Slave 32</div>
            <div class="item" data-value="33">Slave 33</div>
            <div class="item" data-value="34">Slave 34</div>
            <div class="item" data-value="35">Slave 35</div>
        </div>
    </div>

    <h4 class="ui dividing header">Set Depth</h4>
    <div id="table1_datawindow" class="table_datawindow"></div>
    <!-- <div class="content" id="info"></div> -->
    <div id="table1_pagination" class="eleven wide column"></div>
    <div class="five wide column right floated right aligned">
        <h4 class="ui right floated">
            <div class="content" id="table1_info"></div>
        </h4>
    </div>
</div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/semantic.min.js"></script>
<script>
   var prev_value = '';
    String.prototype.ucwords = function() {
        return this.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
    }


  $(function() {
      //table1.init();
      $(".dropdown").dropdown({
            onChange: function (val) {
            loadPage("<?=$app_root?>/api/?function=inclsetup_list&slave_no="+val);

        }
      });

      loadPage("<?=$app_root?>/api/?function=inclsetup_list&slave_no=29");

      	//--->make div editable > start
	$(document).on('click', '.row_data', function(event) 
	{
        event.preventDefault(); 
        prev_value = $(this).html();

		if($(this).attr('edit_type') == 'button')
		{
			return false; 
		}

		//make div editable
		$(this).closest('div').attr('contenteditable', 'true');
		//add bg css
		$(this).addClass('warning').css('padding','5px');

		$(this).focus();
	})	
	//--->make div editable > end


	//--->save single field data > start
	$(document).on('focusout', '.row_data', function(event) 
	{
		event.preventDefault();

		if($(this).attr('edit_type') == 'button')
		{
			return false; 
		}

		var row_id = $(this).closest('tr').attr('row_id'); 
		
		var row_div = $(this)				
		.removeClass('warning') //add bg css
		.css('padding','')

		var col_name = row_div.attr('col_name'); 
		var col_val = row_div.html(); 

		var arr = {};
		arr[col_name] = col_val;

		//use the "arr"	object for your ajax call
		$.extend(arr, {row_id:row_id});

        $.get("<?=$app_root?>/api/?function=inclsetup_edit&row_id="+row_id+"&value="+col_val, null).fail(function(){
            row_div.html(prev_value);
            //console.log("error");
        });
        //out put to show
		//console.log( '<pre class="bg-success">'+JSON.stringify(arr, null, 2) +'</pre>');
		
	})	
	//--->save single field data > end
  });

  function loadPage(access_url) {

    $.get(access_url, function(data, status) {
        if(status == 'success') {

            var myObj = JSON.parse(data);
            var table_output = '';

            var key_names;
            var className = ''; 
            var table_output = "<table class='ui celled compact striped collapsing brown table'><thead><tr>";

            if(myObj.records.length > 0) {
                key_names = Object.keys(myObj.records[0]);
                for(var ai = 1; ai < key_names.length; ai++) {
                    if(myObj.text_align)
                        className = " class='"+myObj.text_align[ai]+" aligned'";

                    table_output += "<th"+className+">" + key_names[ai].replace('_', ' ').ucwords() + "</th>";
                }
            }
            table_output += "<th class='center aligned'>Action</th>";
            table_output += "</tr></thead><tbody>";
            $.each(myObj.records, function (val) {
                className = ''; 
                
                table_output += "<tr row_id='"+myObj.records[val].row_id+"'>";
                
                for(var inx = 1; inx < key_names.length; inx++) {
                    if(myObj.text_align)
                        className = " class='"+myObj.text_align[inx]+" aligned'";
                    if(inx == 2)
                        table_output += "<td"+className+"><div class='row_data' edit_type='click' col_name='depth'>"+myObj.records[val][key_names[inx]]+"</div></td>";
                    else
                        table_output += "<td"+className+">"+(myObj.records[val][key_names[inx]]?myObj.records[val][key_names[inx]]:"")+"</td>";
                }
                table_output += "<td class='center aligned'>";
                table_output += "<button class='ui circular small inverted blue icon button' onClick=\"" + self.prefix + ".mEditFunc(" + myObj.records[val].row_id + ")\"><i class='edit icon'></i></button>";
                table_output += "</td>";

                table_output += "</tr>";
            });
            table_output += "</tbody></table>";

        }

        $('#table1_datawindow').html(table_output);
    });  
    
  }
  
</script>
</body>  
</html>
