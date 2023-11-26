<?php include('include/header.php'); ?>
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">  
  <style>
  .cwhite{ color:#FFFFFF}
  </style>
<div class="body-container">

<div class="container">
  <div class="row" >
  <div class="col-md-12" style="margin-top:15px">

<div class="row">
  <div class="col-md-12" style="margin-top:15px">
   <table id="datatables" class="table table-striped table-bordered" data-page-length='10'>
                    
        <?php
		
		function balance($gst_no)
		{
			 global $db;
	 $total='';
	 $stmt3 = $db->prepare("SELECT token FROM tbl_invoice_to where gst_no='$gst_no' and type=1");
			$stmt3->execute();
			while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
			{
				$token=$row3['token'];
				
				 $stmt4 = $db->prepare("SELECT total FROM tbl_invoice_data where token='$token'");
			$stmt4->execute();
			while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC))
			{
				$totaldata=$row4['total'];					   }
					$total=$total+$totaldata;				   }
				
			return $total;
			}
		 ?>            
                    
                    
                      <thead>
                        <tr>
                        
                         <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>GSTIN</th>
                            <th>Balance</th>
                            
                            <th>Summery</th>
                        </tr>
                      </thead>

<tfoot>
            <tr>
                 <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>GSTIN</th>
                             <th>Balance</th>
                            <th>Summery</th>
            </tr>
        </tfoot>
                      <tbody>
                       
                       
                      
                       
                       <?php 
					  $rown=0;
					   $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type='1' GROUP BY gst_no order by id desc ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$rown=$rown+1;
					  
					    ?>
                        
                        <tr>
                        
                         <td><?php echo $rown ?></td>
                           <td><?php echo $row['name'] ?></td>
                          
                           <td><?php echo $row['gst_no'] ?></td>
                            <td><?=balance($row['gst_no'])?></td>
                           
                       
                         <td>
                       
                           
                         <a href="#myModal" role="button" class="" data-toggle="modal" onclick="billstate('<?=$row['gst_no']?>');"><button class="btn btn-primary btn-xs customer-select" data-title="Edit" data-toggle="modal" data-target="#edit">Select</button></a>
                       
                       
                         </td>
                       
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                    
                        
                        
                      </tbody>
                    </table>
</div>
</div>

</div>
  </div>

</div>

<div class="panel-footer">
<center><strong>Powerd By <a>taxDoctor</a></strong></center>
</div>
</div>

<style>
.modal-dialog {
    width: 90% !important;
   
}

</style>


<div id="myModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Client List</h4>

            </div>

            <div class="modal-body" id="modal-body">

               
             
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>

<script>
function billstate(str11)
{

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="<?=url()?>transection_record.php" //Edit this Line Ac to Your page
url=url+"?qry="+str11

xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("post",url,true)
xmlHttp.send(null)
}function stateChanged()
{

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("modal-body").innerHTML=xmlHttp.responseText;
 copyValuestat();
 }

else
{
document.getElementById("modal-body").innerHTML="<center><img src=<?=url()?>images/loader.gif height=30 /></center>";
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