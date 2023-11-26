<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
	
}

include_once 'dbconfig.php';


if(isset($_POST['btn']))
	{
		
		try{
		
		$orno='';
$dateofloading='';
$truckno='';
$stnno='';
$stationfrom='';
$plant='';
$stationto='';
$trucktype='';
$kotloading='';
$noofboxes='';
$weightloading='';
$reportingdate='';
$unloading='';
$damage='';
$actualamount='';
$billno='';
$paid='';
$supplementryneed='';
$supplementrybillno='';
$supplementrypaid='';
$detention='';
$transittime='';
$latedelivery='';
$currentrate='';
$remarks='';
		
		
		
		
		
		
		$id=$_POST['id'];
$orno=$_POST['orno'];
$dateofloading=$_POST['dateofloading'];
$date_searchq=explode('/',$_POST['dateofloading']);
$date_search=$date_searchq[2].$date_searchq[1].$date_searchq[0];
$truckno=$_POST['truckno'];
$stnno=$_POST['stnno'];
$sapno=$_POST['sapno'];
$stationfrom=$_POST['stationfrom'];
$plant=$_POST['plant'];
$stationto=$_POST['stationto'];
$trucktype=$_POST['trucktype'];
$kotloading=$_POST['kotloading'];
$noofboxes=$_POST['noofboxes'];
$weightloading=$_POST['weightloading'];
$amt=$_POST['amt'];
$pon=$_POST['pon'];
$gann=$_POST['gann'];
$unin=$_POST['unin'];


$remarks=$_POST['remarks'];


	$stmt = $db->prepare("UPDATE loading_information SET orno=:orno,
 dateofloading= :dateofloading,
  date_search=:datese,
   truckno= :truckno,
 sapno=:sapno,
	   stnno=:stnno,
	   stationfrom=:stationfrom,
	   plant=:plant,
	   stationto=:stationto,
	   trucktype=:trucktype,
	   kotloading=:kotloading,
	   noofboxes=:noofboxes,
	   weightloading=:weightloading,
	   pon=:pon,
	   gann=:gann,
	   amt=:amt,
	   unin=:unin,remarks=:remarks where id= '$id'
	");
			$stmt->bindParam(":orno",$orno);
			$stmt->bindParam(":dateofloading",$dateofloading);
			$stmt->bindParam(":datese",$date_search);
			$stmt->bindParam(":truckno",$truckno);
			$stmt->bindParam(":stnno",$stnno);
			$stmt->bindParam(":sapno",$sapno);
			$stmt->bindParam(":stationfrom",$stationfrom);
			$stmt->bindParam(":plant",$plant);
			
			$stmt->bindParam(":stationto",$stationto);
			$stmt->bindParam(":trucktype",$trucktype);
			$stmt->bindParam(":kotloading",$kotloading);
			$stmt->bindParam(":noofboxes",$noofboxes);
			
			$stmt->bindParam(":weightloading",$weightloading);
			
				$stmt->bindParam(":pon",$pon);
					$stmt->bindParam(":gann",$gann);
						$stmt->bindParam(":unin",$unin);
			
			$stmt->bindParam(":remarks",$remarks);
			$stmt->bindParam(":amt",$amt);
			
			$stmt->execute();
			
			
		}
	catch(PDOException $e){
		echo $e->getMessage();
	}		
}


$q=$_GET['id'];
$stmt = $db->prepare("SELECT * FROM tbl_users WHERE user_id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>invoice system</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link href="style.css" rel="stylesheet" media="screen">

</head>

<body style=" background-color:#fafafa">

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Billing System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li ><a href="bills.php">Invoices</a></li>
            <li class="active"><a href="home.php">Create Invoices</a></li>
            <li><a href="#">User</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $row['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    
<div class="body-container">


<div class=" container-fluid">
 <div class="row">
 <div class="col-md-12">
 <div class="row">
 
 
 
 <div class="col-md-12">
 
 <?php   $stmt = $db->prepare("SELECT * FROM loading_information where id='$q'");
 $stmt->execute();
 while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
  ?>
 
 <form method="post" action="" name="form1">
 <div class="col-md-4"></div>
 <div class="col-md-4">
 
 
 <div class="row  panel panel-default">
 <div class="panel-heading">
							<h4 class="float-left">Update Loading Information</h4>
							
							<div class="clear"></div>
						</div>
 <div class="col-md-12 panel-body form-group form-group-sm ">
 
 
 <div class="form-group">
 <input type="text"  name="id" id="orno"  value="<?php echo $row['id'] ?>" style="display:none" />
					<input type="text" class="form-control" name="orno" id="orno" placeholder="OR No." value="<?php echo $row['orno'] ?>" required />
				</div>
                  <div class="form-group">
					<input type="text" class="form-control" name="dateofloading" id="datetimepicker12" value="<?php echo $row['dateofloading'] ?>" placeholder="Date Of Loading" required />
				</div>
                <div class="form-group">
					<input type="text" class="form-control" name="truckno" id="truckno" value="<?php echo $row['truckno'] ?>" placeholder="Truck No."required />
				</div>
                <div class="form-group">
					<input type="text" class="form-control" name="stnno" id="stnno" value="<?php echo $row['stnno'] ?>" placeholder="STN No." required />
				</div>
                <div class="form-group">
					<input type="text" class="form-control" name="sapno" id="stnno" placeholder="SAP No." value="<?php echo $row['sapno'] ?>" required />
				</div>
                
                <div class="form-group">
					<select class="form-control" name="plant" onChange="main_cat(this.value);" >
                    <option >Select Plant</option>
                    
                    <?php 
					$stmt = $db->prepare("SELECT UNIT_NAME FROM rate_list GROUP BY UNIT_NAME");
					$stmt->execute();
					while($row1 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
					?>
                    <option <?php if($row['plant']==$row1['UNIT_NAME']) {?> selected="selected" <?php } ?>  value="<?php echo $row1['UNIT_NAME'] ?>"><?php echo $row1['UNIT_NAME'] ?></option>
                    
                    <?php }?>
                    
                    </select>
				</div>
                
                <span id="cat" >
                <div class="form-group">
                <input name="stationfrom"  value="<?php echo $row['stationfrom'] ?>"  type="text" style="display:none">
					<select class="form-control"  disabled="disabled"  >
                    <option  value="<?php echo $row['stationfrom'] ?>"><?php echo $row['stationfrom'] ?></option>
                    		
                    </select>
                  
				</div>
                
                 
<div class="form-group">
 <input name="stationto"  value="<?php echo $row['stationto'] ?>"  type="text" style="display:none">
					<select class="form-control"    disabled="disabled" >
                    <option value="<?php echo $row['stationto'] ?>"><?php echo $row['stationto'] ?></option>
                    
                    </select>
                    
				</div>  
                  </span>
                <div class="form-group">
					<select class="form-control" name="trucktype"  onChange="commentSubmit4();" >
                    <option>Select Truck Type</option>
                    <option <?php if($row['trucktype']=="6 TYRE") {?> selected="selected" <?php } ?> >6 TYRE</option>
                    <option <?php if($row['trucktype']=="10 TYRE") {?> selected="selected" <?php } ?>>10 TYRE</option>
                    <option <?php if($row['trucktype']=="24 FT CONTAINER") {?> selected="selected" <?php } ?>>24 FT CONTAINER</option>
					<option <?php if($row['trucktype']=="28 FT CONTAINER") {?> selected="selected" <?php } ?>>28 FT CONTAINER</option>
                    <option <?php if($row['trucktype']=="32 FT CONTAINER") {?> selected="selected" <?php } ?>>32 FT CONTAINER</option>
                    </select>
				</div> 
                
                <div class="form-group">
                <span id="cat1" >
					<input class="form-control" name="amt" id="kotloading" value="<?php echo $row['amt'] ?>" placeholder="Ammount" type="text">
                    </span>
				</div>
                
                <div class="form-group">
					<input type="text" class="form-control" name="kotloading" id="kotloading" placeholder="Kot Loading" value="<?php echo $row['kotloading'] ?>" required />
				</div>   
                
                <div class="form-group">
					<input type="text" class="form-control" name="noofboxes" id="noofboxes" placeholder="No. Of Boxes" value="<?php echo $row['noofboxes'] ?>" required />
				</div>    
                
                <div class="form-group">
					<select class="form-control" name="weightloading" >
                    <option >Select Weight Loading</option>
                    <option <?php if($row['weightloading']=="9 TON") {?> selected="selected" <?php } ?>>9 TON</option>
                    <option <?php if($row['weightloading']=="13.5 TON") {?> selected="selected" <?php } ?> >13.5 TON</option>
                    <option <?php if($row['weightloading']=="15 TON") {?> selected="selected" <?php } ?> >15 TON</option>
                    </select>
				</div>  
                
                 <div class="form-group">
					<input type="text" class="form-control" name="pon" id="noofboxes" placeholder="PO Number" value="<?php echo $row['pon'] ?>"  />
				</div>    
                
                 <div class="form-group">
					<input type="text" class="form-control" name="gann" id="noofboxes" placeholder="GAN Number" value="<?php echo $row['gann'] ?>"  />
				</div>    
                
                 <div class="form-group">
					<input type="text" class="form-control" name="unin" id="noofboxes" value="<?php echo $row['unin'] ?>" placeholder="Unique Number"  />
				</div>            
                
                <div class="form-group">
                 
              <button class="btn btn-success" style="margin-top:100px; margin-right:50px;" name="btn" id="btn"><b>Submit</b></button> </div>          
 
 
                </div>
                
                </div>
               
 

				
 
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker12').datepicker({
                inline: true,
				autoclose: true,
				format:'dd/mm/yyyy' ,
                sideBySide: true
            });
        });
    </script>

				
 
            <script type="text/javascript">
$('#mycheckbox').change(function() {
    $('#divsup').toggle();
});
</script>   
                
                
                
                
               
              </div>
        <div class="col-md-4"></div>      
              </form>	
              <?php } ?>
              
              </div>
                
                
                
                
                
                
                <!-------second block------->
                
                
                
                
                
                <!------block 3------------->
              



 </div>
 
 </div>
 </div>
 
</div>
</div>

</div>
</div>


</div>

</div>
<script>
$('.datepicker').datepicker();
</script>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row"><div class="col-md-12"><div class="col-md-1 form-group"><a href="#" class="remove_field"><button class="close pull-left" style="background-color:#F00 !important;">&times;</button></a></div><div class="col-md-7"><div class="service form-group"><input name="service[]" placeholder="Enter item title and / or description" class="form-control" type="text"></div></div><div class="col-md-4"><div class="price form-group"><input name="price[]" placeholder="0.00" class="form-control" type="text"></div></div></div></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    })
});
</script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script language="javascript">
function main_cat(str1)
{
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="getvalue.php" //Edit this Line Ac to Your page
url=url+"?qry="+str1

xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("post",url,true)
xmlHttp.send(null)
}function stateChanged()
{

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("cat").innerHTML=xmlHttp.responseText
 }

else
{
document.getElementById("cat").innerHTML="<img src=images/loader.gif height=30 />";
}
}function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}


</script>


<script>
function commentSubmit4(){
		
		
		
		var comments=form1.stationfrom.value;
		var plan=form1.plant.value;
		var weight=form1.trucktype.value;
		
		var xmlhttp = new XMLHttpRequest(); //http request instance
		xmlhttp.onreadystatechange=stateChanged
		xmlhttp.onreadystatechange = function(){ //display the content of insert.php once successfully loaded
			if(xmlhttp.readyState==4&&xmlhttp.status==200){
				
				
				document.getElementById('cat1').innerHTML = xmlhttp.responseText; //the chatlogs from the db will be displayed inside the div section
				
			}else
{
document.getElementById("cat1").innerHTML="<img src=images/loader.gif height=30 />"
}
		}
		xmlhttp.open('GET', 'getvalue1.php?qry='+comments+'&wry='+weight+'&xry='+plan, true); //open and send http request
		
		xmlhttp.send();
		
			function stateChanged()
{

if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete")
 {
 document.getElementById("cat1").innerHTML=xmlhttp.responseText;
 
 }

else
{
document.getElementById("cat1").innerHTML="<img src=images/loader.gif height=30 />";
}
}		
		 //document.form1.reset();
	}
	
</script>


 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
</body>
</html>