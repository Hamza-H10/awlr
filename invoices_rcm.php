<?php include('include/header.php'); ?>
    
  
<div class="body-container">

<!------head------->
<div class=" container">
 <div class="row">
 
 <div class=" col-md-12" id="bill_list">
<table id="datatables" class="table table-striped table-bordered" data-page-length='10'>
                    
                    
                    
                    
                      <thead>
                        <tr>
                        
                         <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>Mobile No.</th>
                            <th>Payment</th>
                            
                            <th>Perform</th>
                        </tr>
                      </thead>

<tfoot>
            <tr>
                 <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>Mobile No.</th>
                            <th>Payment</th>
                            
                            <th>Perform</th>
            </tr>
        </tfoot>
                      <tbody>
                       
                       
                      
                       
                       <?php 
					  $rown=0;
					  
					  $stmt1 = $db->prepare("SELECT token FROM tbl_invoice_data where reverse_charge='1'  ");
			$stmt1->execute();
		
			if($stmt1->rowCount()>0){
			while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
			{
				$rcm_invoice_token[]="'".$row1['token']."'";
				}
				
				$rcm_invoice_token_data=implode(',', $rcm_invoice_token);
					 
					   $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type='1' and token in(".$rcm_invoice_token_data.") order by id desc ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$rown=$rown+1;
					  
					    ?>
                        
                        <tr>
                        
                         <td><?php echo $rown ?></td>
                           <td><?php echo $row['name'] ?></td>
                          
                           <td><?php echo $row['mobile'] ?></td>
                           
                        <td>
                          <?php 
					 $tk=$row['token'];
					   $stmt3 = $db->prepare("SELECT * FROM tbl_payment where token='$tk'");
			$stmt3->execute();
			while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
			{
				$pay='';
					  if($row3['type']==0){$pay='Un Paid';}else if($row3['type']==1){$pay='Paid';}
else if($row3['type']==2){$pay='Partial Paid';}					    ?>
                        <?= $pay?>
                        
						<?php }?>
                        
                        </td>
                         <td>
                           
                         <a href="view-invoice.php?<?php echo $row['token'] ?>"><button class="btn btn-info btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon  glyphicon-copy"></span></button></a>
                         
                         <a target="_blank" href="pdf.php?<?php echo $row['token'] ?>"><button class="btn btn-success btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-print"></span></button></a>
                         
                         <a href="edit.php?<?php echo $row['token'] ?>"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button></a>
                         
                        
                         
                      <a onclick="sms('<?=$row['id']?>');"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">SMS</button></a>    
                         
                         <a onclick="delete_bill('<?=$row['token']?>');">
                         <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button>
                         </a>
                         </td>
                       
                          
                        </tr>
                        <?php } }?>
                        
                        
                        
                    
                        
                        
                      </tbody>
                    </table>
                    <input type="text" id="delete_id" class="hidden" />
 </div>
 
 </div>
 
</div>
<!------head close------->
<style>
.bbgw{border-radius:3px; border:1px solid #CCC; background-color:#FFFFFF;box-shadow:0px 0px 4px #ccc; }
.thcfw{border-bottom:solid 1px #ccc; background-color:rgb(129, 184, 77); color:#FFFFFF; line-height:26px; text-align:center; border-top:2px solid rgb(8, 61, 95); box-shadow:0px 0px 4px #ccc; font-weight:600; text-shadow:0px 0px 4px #666 }

</style>
<!------company details------->

<div class=" container" style="margin-bottom:15px">
 <div class="row" ></div>
 
</div>
<!------company details------->

<!------service product------->
<div class=" container">
 <div class="row"><span style="width:20%; text-align:center ">
 
 </span></div>
 
</div>
<!------service product close------->

</div>

</div>
</div>


</div>
<br />
<br /><br />
<br /><br />
<br /><br />
<br />
<div class="panel-footer">
<center><strong>Powerd By <a>taxDoctor</a></strong></center>
</div>
</div>

<div id="confirm_box" style="display:none">
	<div class="confirmModal_content" >
	Are You Sure! To Delete Bill
	</div>
	<div class="confirmModal_footer">
		<button type="button"  class="btn btn-primary" data-confirmmodal-but="ok" >Confirm</button>
		<button type="button" class="btn btn-default" data-confirmmodal-but="cancel">Cancel</button>
	</div>
</div>

<div id="info" style="display:none">
	
</div>



<script>

function sms(id)
{
	var uid=id;

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="<?=url()?>process/user.php" //Edit this Line Ac to Your page
url=url+"?id="+uid+"&qry=sms"

xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("post",url,true)
xmlHttp.send(null)
}function stateChanged()
{

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("info").innerHTML=xmlHttp.responseText;
 
 notify_box();
 location.reload();

 }

else
{
document.getElementById("info").innerHTML="<center>Please Wait While We Process Your Request <img src=<?=url()?>images/loader.gif height=20 /></center>";

notify_box();
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


function delete_bill(id){
		$('#delete_id').val(id);
	$('#confirm_box').confirmModal({
			topOffset: 0,
			top: 0,
			onOkBut: function () {delete_ok()},
			onCancelBut: function() {},
			onLoad: function() {},
			onClose: function() {}
		});}
		
	function delete_ok(){
		var did=document.getElementById('delete_id').value; 
		

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="<?=url()?>process/invoice.php" //Edit this Line Ac to Your page
url=url+"?id="+did+"&qry=delete"

xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("post",url,true)
xmlHttp.send(null)
}function stateChanged()
{

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("info").innerHTML=xmlHttp.responseText;
 
 notify_box();
 
 }

else
{
document.getElementById("info").innerHTML="<center>Please Wait While We Process Your Request <img src=<?=url()?>images/loader.gif height=20 /></center>";

notify_box();
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
	
	
		
</script>

<?php include('include/footer.php'); ?>