<?php include('include/header.php'); 
if($_POST){
	
			
$name='';
$mobile='';
$gstno='';
$gststate='';
$gstsupply='';
$email='';
$pan='';
$address='';
$type='';
$token='';
	
	$name=$_POST['in_name'];
$mobile=$_POST['in_mobile'];
$gstno=$_POST['in_gst'];
$gststate=$_POST['in_state'];
$gstsupply=$_POST['in_place_supply'];
$email=$_POST['in_email'];
$pan=$_POST['in_pan'];
$address=$_POST['in_address'];
$type='3';
$token='';
	
	$stmt = $db->prepare("INSERT INTO tbl_invoice_to(name,mobile,gst_no,gst_state,gst_supply,email ,pan_number,address,type,token) VALUES(:name, :mobile, :gst_no, :gst_state, :gst_supply, :email , :pan_number, :address, :type, :token)");
			$stmt->bindParam(":name",$name);
			$stmt->bindParam(":mobile",$mobile);
			$stmt->bindParam(":gst_no",$gstno);
			$stmt->bindParam(":gst_state",$gststate);
			$stmt->bindParam(":gst_supply",$gstsupply);
			$stmt->bindParam(":email",$email);
			$stmt->bindParam(":pan_number",$pan);
			$stmt->bindParam(":address",$address);
			$stmt->bindParam(":type",$type);
			
			$stmt->bindParam(":token",$token);
			
			
			
			$stmt->execute();
	}
	
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	
	$urlred=$protocol.$_SERVER['HTTP_HOST'].strtok($_SERVER["REQUEST_URI"],'?');
if(isset($_GET['id'])){
	$id=0;
	$id=$_GET['id'];
	  
$stmt = $db->prepare("DELETE FROM tbl_invoice_to WHERE id='$id'  ");
					
					if($stmt->execute())
					
					{$_SESSION['FLASH'] = "User Deleted Successfully";}
					else{$_SESSION['FLASH'] = "Opps Somthing going wrong!";}
					
					header("Location: ".$urlred);
					exit;
}
?>
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">  
  <style>
  .cwhite{ color:#FFFFFF}
  .thcfw{border-bottom:solid 1px #ccc; background-color:#5cb85c; color:#FFFFFF; line-height:26px; text-align:center; border-top:2px solid rgb(8, 61, 95); box-shadow:0px 0px 4px #ccc; font-weight:600; text-shadow:0px 0px 4px #666 }
  </style>
<div class="body-container">

<div class="container">
  <div class="row" >
  <div class="col-md-12 bbgw ">
 <div class="col-md-6">
  <form method="post" action="">
 <table style="width:100%">
 <tbody><tr class="thcfw">
 <td colspan="2">Add Clients</td>
 </tr>
 
 <tr>
 <td colspan="2">&nbsp;
 
 
					
 </td>
 </tr> 
 
 <tr>
 <td>
 <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="in_name" class="form-control" placeholder="Billing Name" onKeyUp="copyValue()" onSelect="copyValue()" onClick="copyValue()" required type="text">
        <span id="check-e"></span>
        </div>
 </td>
 <td>
 <div class="form-group" style=" margin-left:10px; margin-top:5px">
        <input class="form-control" placeholder="PAN Number (optional)" onKeyUp="copyValue3()" name="in_pan" id="textValue3" onSelect="copyValue3()" type="text">
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 <tr>
 <td>
 <div class="form-group">
        <input class="form-control" placeholder="Mobile Number" onKeyUp="copyValue2()" name="in_mobile" id="textValue2" onSelect="copyValue2()" required type="text">
        <span id="check-e"></span>
        </div>
 </td>
 <td>
 <div class="form-group" style=" margin-left:10px">
        <input class="form-control" name="in_email" placeholder="Email ID (optional)" onKeyUp="copyValue4()" id="textValue4" onSelect="copyValue4()" type="text">
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 

 
 <tr>
 <td><div class="form-group">
					<select class="form-control" name="in_state" id="state_in" onselect="copyValue8()" onChange="billstate(this.value);" >
                    <option>Select State</option>
                    
                    <?php 
					$stmt = $db->prepare("SELECT * FROM sheet1");
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
					?>
                    <option value="<?php echo $row['Name_of_the_State'] ?>"><?php echo $row['Name_of_the_State'] ?></option>
                    
                    <?php }?>
                    
                    </select>
				</div></td>
                <td>
                <div style="margin-left:10px; ">State Code:<span id="billstate"></span></div>
                </td>
 </tr>
 
 <tr>
 <td colspan="2">
 
        
        <div class="form-group">
 <textarea class="form-control" name="in_address" placeholder="Address" onKeyUp="copyValue5()" id="textValue5" onSelect="copyValue5()" required></textarea>
        
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 
 <tr>
  <td>
  <div class="form-group">
        <input class="form-control" name="in_gst" placeholder="GSTIN" onKeyUp="copyValue6()" id="textValue6" onSelect="copyValue6()" required type="text">
        <span id="check-e"></span>
        </div>
  </td>
 <td>
 
        
        <div class="form-group">
 <input class="form-control" name="in_place_supply" placeholder="Place Of Supply" style="margin-left:10px" onKeyUp="copyValue7()" id="textValue7" onSelect="copyValue7()" required>
        
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 
 <tr>
 <td colspan="2">
 
 <input id="action_create_invoice" class="btn btn-success float-right" name="sub" value="Add User" style="margin-top:10px" type="submit">
 
 </td>
 </tr>
  
 
 
 </tbody></table>
  </form>
 </div>
 
 <div class="col-md-6">
 <table id="datatables" class="table table-striped table-bordered" data-page-length='10'>
                    
                    
                    
                    
                      <thead>
                        <tr>
                        
                         <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>GSTIN</th>
                            
                            
                            <th>Perform</th>
                        </tr>
                      </thead>

<tfoot>
            <tr>
                 <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>GSTIN</th>
                            <th>Perform</th>
            </tr>
        </tfoot>
                      <tbody>
                      
                       
                      
                       
                       <?php 
					  $rown=0;
					   $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type in(1,3) GROUP BY gst_no order by id desc ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$rown=$rown+1;
					  
					    ?>
                        
                        <tr>
                        
                         <td><?php echo $rown ?></td>
                           <td><?php echo $row['name'] ?></td>
                          
                           <td><?php echo $row['gst_no'] ?></td>
                           
                       
                         <td>
                       <?php if($row['type']==3){
						  ?>
                           
                         <a href="<?= $urlred.'?id='.$row['id']?>" ><button class="btn btn-primary btn-xs customer-select" data-title="Edit" data-toggle="modal" data-target="#edit">Delete</button></a>
                       <?php } ?>
                       
                         </td>
                       
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                    
                        
                       
                      </tbody>
                    </table>
 </div>
 </div>
 
 
  </div>

</div>

<div class="panel-footer">
<center><strong>Powerd By <a>taxDoctor</a></strong></center>
</div>
</div>

<?php
if(isset($_SESSION['FLASH'])){
 ?>
 <div id="info" style="display:none">
	<center><?= $_SESSION['FLASH'] ?></center>
</div>
<script>
$(document).ready(function() {
	notify_box();
	function notify_box(){
	$('#info').notifyModal({
			duration : 2500,
			placement : 'center',
			overlay : true,
			type : 'notify',
			icon: false,
			onClose : function() {}
		});
		

	}
	
	});
</script>
<?php }
unset($_SESSION['FLASH']);

?>
<style>
.modal-dialog {
    width: 90% !important;
   
}

</style>




<script language="javascript">
function billstate(str11)
{
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="<?=url()?>getvalue.php" //Edit this Line Ac to Your page
url=url+"?qry="+str11

xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("post",url,true)
xmlHttp.send(null)
}function stateChanged()
{

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("billstate").innerHTML=xmlHttp.responseText;
 copyValuestat();
 }

else
{
document.getElementById("billstate").innerHTML="<img src=<?=url()?>images/loader.gif height=30 />";
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
<?php include('include/footer.php'); ?>