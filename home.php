<?php include('include/header.php');
$stmtid = $db->prepare("SELECT * FROM tbl_setting where id=1");
$stmtid->execute();
			while($rowid = $stmtid->fetch(PDO::FETCH_ASSOC))
			{
			
						
						
						$details=unserialize($rowid['details']);
						
							
						$image_url=$rowid['image_url'];
					
						
						}

 ?>
    
   <form method="post" enctype="multipart/form-data" action="insertdata.php" > 
<div class="body-container" id="page_content">

<!------head------->
<div class=" container">
 <div class="row">
 
 <div class=" col-md-12">
 <div class="col-md-6"><img src="<?=url()?>uploads/<?= $image_url ?>" class="img-responsive" width="300px" /></div>
 <div class="col-md-6">
 <table>
 <tr>
 <td>Reference &nbsp;&nbsp;:</td>
 <td><?= $gst_invoice_config['bill_prefix']?>/17-18/.....</td>
 </tr>
 <tr>
 <td>Billing Date :</td>
 <td><div class="form-group">
					<input type="text" class="form-control" name="billingdate" value="<?php echo date("d".'/'."m".'/20'."y") ?>" id="datetimepicker12" required />
				</div>
              
                </td>
 </tr>
 </table>
   
 </div>
 </div>
 
 </div>
 
</div>
<!------head close------->
<style>
.bbgw{border-radius:3px; border:1px solid #CCC; background-color:#FFFFFF;box-shadow:0px 0px 4px #ccc; }
.thcfw{border-bottom:solid 1px #ccc; background-color:#5cb85c; color:#FFFFFF; line-height:26px; text-align:center; border-top:2px solid rgb(8, 61, 95); box-shadow:0px 0px 4px #ccc; font-weight:600; text-shadow:0px 0px 4px #666 }

</style>
<!------company details------->

<div class=" container" style="margin-bottom:15px">
 <div class="row" >
 
 <div class=" col-md-12" style=" padding-bottom:10px; padding-top:15px; ">
 <div class="col-md-4 bbgw"   >
 <div class="col-md-12 "  >
 <div class="row">
 
 
 <table style="width:100%">
 <tr  class="thcfw">
 <td>Our Information</td>
 </tr>
 <tr>
 <tr>
 

 


 <td><h5 style="text-transform:uppercase; margin-bottom:0px; font-weight:600"><?=$details['name']?></h5><p style="text-transform:uppercase;font-weight:600; font-size:12px;"><?=$details['name_tag']?></p></td>
 </tr>
 <tr>
 <td>
 <strong>Address</strong><br />
 <?=$details['address1']?> <br />
 <?=$details['address2']?><br />
 <?=$details['address3']?> 
 <?=$details['address4']?> <?php if($details['address4']!=''){echo '<br>';} ?>
 <br /><br />
 <strong>Mobile No :</strong>  <?=$details['contact']?>
 </td>
 </tr>
 <?php if($details['landline']!=''){?>
<tr>
 <td>
 <strong>Landline :</strong> <?=$details['landline']?>
 </td>
 </tr>
<?php } ?>
 
<?php if($details['email']!=''){?>
<tr>
 <td>
 <strong>Email :</strong> <?=$details['email']?>
 </td>
 </tr>
<?php } ?>

<?php if($details['cin']!=''){?>
<tr>
 <td>
 <strong>CIN :</strong> <?=$details['cin']?>
 </td>
 </tr>
<?php } ?>

 <tr>
 <td>
 <strong>GSTIN :</strong> <?=$details['gstin']?>
 </td>
 </tr>
 <tr>
 <td>
 <span ><strong title="Tick Check box if Yes, Default No" class="titleModal" data-placement="bottom">Paid  Under Reverse Charge :</strong> <input type="checkbox" name="reverse_charge" value="1" />
 </span>
 </td>
 </tr>
 </table>
 <br />
 </div>
 </div>
 </div>
 <div class="col-md-4">
 <div class="col-md-12 bbgw " >
 <div class="">
 
 <table style="width:100%">
 <tr class="thcfw">
 <td colspan="2">Tax Invoice</td>
 </tr>
 
 <tr>
 <td colspan="2">
 
 <span title="Select Saved Clients/Privious Billed Client" class="titleModal" data-placement="bottom"><a href="#myModal" role="button" class="" data-toggle="modal" style="padding:5px"><i class="glyphicon glyphicon-user " style=" padding:5px"></i>Select Client</a></span>
 
					
 </td>
 </tr> 
 
 <tr>
 <td>
 <div class="form-group" style="margin-top:5px">
        <input id="textValue" name="in_name" class="form-control" type="text" placeholder="Billing Name" onkeyup="copyValue()" onselect="copyValue()" onclick="copyValue()" required />
        <span id="check-e"></span>
        </div>
 </td>
 <td>
 <div class="form-group" style=" margin-left:10px; margin-top:5px">
        <input class="form-control" type="text" placeholder="PAN Number (optional)" onkeyup="copyValue3()" name="in_pan" id="textValue3" onselect="copyValue3()"/>
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 <tr>
 <td>
 <div class="form-group" >
        <input class="form-control" type="text" placeholder="Mobile Number" onkeyup="copyValue2()"  name="in_mobile" id="textValue2" onselect="copyValue2()" required />
        <span id="check-e"></span>
        </div>
 </td>
 <td>
 <div class="form-group" style=" margin-left:10px">
        <input class="form-control" name="in_email" type="text" placeholder="Email ID (optional)" onkeyup="copyValue4()" id="textValue4" onselect="copyValue4()"/>
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
                <td >
                <div style="margin-left:10px; ">State Code:<span id="billstate" ></span></div>
                </td>
 </tr>
 
 <tr >
 <td colspan="2">
 
        
        <div class="form-group" >
 <textarea class="form-control" name="in_address"  placeholder="Address" onkeyup="copyValue5()" id="textValue5" onselect="copyValue5()" required></textarea>
        
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 
 <tr >
  <td >
  <div class="form-group" >
        <input class="form-control" name="in_gst" type="text" placeholder="GSTIN" onkeyup="copyValue6()" id="textValue6" onselect="copyValue6()" required/>
        <span id="check-e"></span>
        </div>
  </td>
 <td >
 
        
        <div class="form-group" >
 <input class="form-control" name="in_place_supply"  placeholder="Place Of Supply" style="margin-left:10px" onkeyup="copyValue7()" id="textValue7" onselect="copyValue7()" required>
        
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
  
 
 
 </table>
 </div>
 </div>
 </div>
 
 <div class="col-md-4 bbgw">
 <div class="row">
 <div class="col-md-12" >
 <table style="width:100%">
 <tr class="thcfw">
 <td colspan="2">Shipping To</td>
 </tr>
 
 <tr>
 <td colspan="2" style="line-height:24px; font-size:12px; vertical-align:central; color:#666666">
 *Default 'Shipping To' Value As 'Invoice To'
 </td></tr>
 
 <tr>
 <td>
 <div class="form-group" style="margin-top:5px">
        <input class="form-control" type="text" placeholder="Billing Name" name="ad_name" id='mytext' />
        <span id="check-e"></span>
        </div>
 </td>
 <td>
 <div class="form-group" style=" margin-left:10px; margin-top:5px">
        <input class="form-control" name="ad_pan" type="text" placeholder="PAN Number (optional)" id='mytext3'/>
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 <tr>
 <td>
 <div class="form-group" >
 
 
   <input class="form-control" name="ad_mobile" type="text" placeholder="Mobile Number" id='mytext2' />

 <span id="check-e"></span>
        </div>
 </td>
 <td>
 <div class="form-group" style=" margin-left:10px">
        <input class="form-control" name="ad_email" type="text" placeholder="Email ID (optional)"id='mytext4' />
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 
 <tr>
 <td><div class="form-group">
					<select name="ad_state" class="form-control" id="state_ad"  onChange="shipstate(this.value);" >
                    <option>Select State</option>
                    
                    <?php 
					$stmt = $db->prepare("SELECT Name_of_the_State FROM sheet1");
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
					?>
                    <option value="<?php echo $row['Name_of_the_State'] ?>"><?php echo $row['Name_of_the_State'] ?></option>
                    
                    <?php }?>
                    
                    </select>
				</div></td>
                <td>
                 <div style="margin-left:10px; ">State Code:<span id="shipstate" ></span></div>
                </td>
 </tr>
 <tr >
 <td colspan="2">
 
        
        <div class="form-group" >
 <textarea class="form-control" name="ad_address"  placeholder="Address" id='mytext5'></textarea>
        
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
  
 <tr >
  <td >
  <div class="form-group" >
        <input class="form-control" name="ad_gst" type="text" placeholder="GSTIN" id='mytext6' />
        <span id="check-e"></span>
        </div>
  </td>
 <td >
 
        
        <div class="form-group" >
 <input class="form-control" name="ad_place_supply"  placeholder="Place Of Supply" style="margin-left:10px" id='mytext7'>
        
        <span id="check-e"></span>
        </div>
 </td>
 </tr>
 
 </table>
 </div>
 </div>
 </div>
 
 </div>
 
 </div>
 
</div>
<!------company details------->

<!------service product------->
<div class=" container">
 <div class="row">
 
 <div class=" col-md-12">
<div style="border:1px solid #ccc; border-bottom:none;border-radius:5px 5px 0px 0px">
<table cellspacing="0" cellpadding="0"  width="100%" style=" border-radius:5px 5px 0px 0px; line-height:32px;  background-color:#efefef; font-size:16px" >
  
  <tr style="text-align:center" >
    <td style="width:10%"><a  class="add_field_button btn btn-success btn-xs" ><span class="glyphicon glyphicon-plus"  aria-hidden="true"></span></a></td>
    
    <td style="width:50%; border-left:1px solid #ccc; border-right:1px solid #ccc">Type Of Supply</td>
    
    
   
    <td  style="width:20%;border-right:1px solid #ccc">HSN/SAC Code</td>
    <td  style="width:20%"> Price</td>
   
   
   
  </tr>
  
  
</table>
 </div>
 <div>
 <style>
 .servicebox{ width:100%; border:none; text-align:center}
 </style>
 <table class="input_fields_wrap" border="1" bordercolor="#ccc"  width="100%" style="text-align:center; line-height:30px; background-color:#FFFFFF ">
 <tr>
    <td style="width:10%"><a class="btn btn-default btn-xs" style=" padding:5px"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
    
    <td style="width:50%" colspan="2"><input style="width:100%; border:none; height:100%" type="text" placeholder="Enter Services Name" name="services[]"  required="required"/></td>
  
    <td style="width:20%"><textarea class="servicebox" placeholder="Services Description (Optional)" name="description[]" style="height:40px"></textarea></td>
    
    
    <td style="width:20%"><input class="txtcal servicebox" type="text" placeholder="0.00" name="price[]" onkeyup="butcl();" onclick="butcl();" required/></td>
    
  </tr>
 </table>
 </div>
 
 
 
 
 </div>
 
 <span style="width:20%; text-align:center ">
 
 </span>
 <div class="col-md-12">
 <table cellspacing="0" cellpadding="0" style="width:40%; float:right;  line-height:30px; margin-top:15px">
 
  <tr>
    <td style="width:20%; text-align:right "><strong>Sub Total :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><span id="subt">0.00</span>&nbsp;&nbsp;Rs.<input type="text" name="sub_total" id="subt1" class="hidden"/></td>
  </tr>
  <tr>
    <td style=" text-align:right "><strong>Other Charges :&nbsp;</strong></td>
    <td style=" text-align:right; text-align:center "><div class="input-group input-group-sm" style="padding-left:15px">
								<span class="input-group-addon">Rs.</span>
								<input class="txtcal  form-control calculate shipping" name="other_charges" aria-describedby="sizing-addon1" placeholder="0.00" type="text" onkeyup="butcl();" onclick="butcl();" >
							</div></td>
  </tr>
  
  <tr>
    <td style=" text-align:right "><span style="float:right"><strong>GST Rate</strong>
    <select id="select_gst_rate" onchange="calculateSum();">
    <option <?php if($details['gst_rate']['0']=='0'){echo 'selected="selected"';} ?>>0</option>
    <option <?php if($details['gst_rate']['0']=='1.5'){echo 'selected="selected"';} ?> >1.5</option>
    <option <?php if($details['gst_rate']['0']=='2.5'){echo 'selected="selected"';} ?>>2.5</option>
    <option <?php if($details['gst_rate']['0']=='6'){echo 'selected="selected"';} ?>>6</option>
     <option <?php if($details['gst_rate']['0']=='9'){echo 'selected="selected"';} ?>>9</option>
      <option <?php if($details['gst_rate']['0']=='14'){echo 'selected="selected"';} ?>>14</option>
    </select>
    </span>
    </td>
    <td style=" text-align:right; text-align:center "></td>
  </tr>
  
  
  <tr id="trcgst">
    <td style="width:20%; text-align:right "><strong title="CGST means Central Goods and Service Tax. CGST is a part of goods and service tax. It is covered under Central Goods and Service Tax Act 2016. " class="titleModal" data-placement="left">CGST (<span id="cgst_rate"><?=$details['gst_rate']['0']?> </span>%) :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><span id="cgsttax">0.00</span>&nbsp;&nbsp;Rs.<input type="text" name="invoice_cgst" id="cgt1" class="hidden" /></td>
  </tr>
  <tr id="trsgst" >
    <td style="width:20%; text-align:right "><strong title="SGST means State Goods and Service Tax. It is covered under State Goods and service Tax Act 2016. A collection of SGST will be the revenue for State Government." class="titleModal" data-placement="left">SGST (<span id="sgst_rate"><?=$details['gst_rate']['0']?></span>%) :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><span id="sgsttax">0.00</span>&nbsp;&nbsp;Rs.<input type="text" name="invoice_sgst" id="sgt1" class="hidden" /></td>
  </tr>
  <tr id="trigst" style="display:none">
    <td style="width:20%; text-align:right" ><strong title="IGST means Integrated Goods and Service Tax. IGST falls under Integrated Goods and Service Tax Act 2016. Revenue collected from IGST will be divided between Central Government and State Government as per the rates specified by the government. " class="titleModal" data-placement="left">IGST (<span id="igst_rate"><?=2*$details['gst_rate']['0']?></span>%) :&nbsp;</strong>
    </td>
    <td style="width:20%; text-align:center; vertical-align:baseline "><span id="igsttax">0.00</span>&nbsp;&nbsp;Rs.<input type="text" name="invoice_igst" id="igt1" class="hidden" /></td>
  </tr>
  
   <tr>
    <td style="width:20%; text-align:right " id="Outertd">
    Enable IGST <input type="checkbox" id="checkgst" name="igst" value="1" /><br /><strong>TOTAL :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><strong><span id="sum">0.00</span>&nbsp;&nbsp;Rs.</strong><input type="text" name="invoice_total" id="sum1" class="hidden" /></td>
  </tr>
  
  <tr>
    <td style="width:20%; text-align:right ">
    <select id="ddlView" name="payment_type" onclick="Validatepaymeny();" onchange="Validatepaymeny();">
    <option value="0">Payment</option>
    <option value="1">Paid</option>
    <option value="2">Partial Paid</option>
    
    </select></td>
    <td id="paydis" style="width:20%; text-align:center ;display:none">
    <span  >
    <div class="input-group input-group-sm" style="padding-left:15px" id="paydis">
								<span class="input-group-addon">Rs.</span>
								<input class="  form-control" name="invoice_payd"  placeholder="Paid Amount" type="text"  >
                                
							</div>
                            </span>
                            </td>
  </tr>
  
  <tr id="payment_ex" style="display:none">
    <td style="width:20%; text-align:right ">
    <select id="ddtView" name="payment_mode" onclick="Validatepaymeny1();" onchange="Validatepaymeny1();">
    <option value="0">Payment Mode</option>
    <option value="1">Cash</option>
    <option value="2">Online</option>
    <option value="3">Check</option>
    
    </select></td>
    <td style="width:20%; text-align:center ">
    <span id="paydisref" style="display:none">
   
								<input  class="  form-control " name="invoice_payment" aria-describedby="sizing-addon1" placeholder="Refrence Number" type="text" style="margin-top:5px; margin-left:15px; font-size:12px;  width: calc(100% - 15px); "  ></span>
                                <textarea name="payment_note" style="margin-top:5px; width: calc(100% - 15px); margin-left:15px; font-size:12px;" placeholder=" Enter Payment Note(Optional)"></textarea>
                                
							
                            
                            </td>
  </tr>
  
  <tr>
    <td style="width:20%; text-align:right "></td>
    <td style="width:20%; text-align:center "><input id="action_create_invoice" class="btn btn-success float-right" name="sub" value="Create Invoice"  type="submit" style="margin-top:10px"></td>
  </tr>
  
</table>

 </div>
 
 </div>
 
</div>
<!------service product close------->

</div>
</form>
</div>
</div>


</div>



<?php include('include/footer-part.php'); ?>

</div>

</div>




 

<!-- Modal HTML -->

<div id="myModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Client List</h4>

            </div>

            <div class="modal-body">

               
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
                       
                           
                         <a class="" onclick="select_client(<?= $row['id'] ?>);" data-dismiss="modal"><button class="btn btn-primary btn-xs customer-select" data-title="Edit" data-toggle="modal" data-target="#edit">Select</button></a>
                        <span style="display:none">
                         <input type="text" id="clcvn-<?= $row['id'] ?>" value="<?= $row['name'] ?>" />
                         <input type="text" id="clcvp-<?= $row['id'] ?>" value="<?= $row['pan_number'] ?>" />
                         <input type="text" id="clcvm-<?= $row['id'] ?>" value="<?= $row['mobile'] ?>" />
                         <input type="text" id="clcve-<?= $row['id'] ?>" value="<?= $row['email'] ?>" />
                         <input type="text" id="clcvs-<?= $row['id'] ?>" value="<?= $row['gst_state'] ?>" />
                         <input type="text" id="clcva-<?= $row['id'] ?>" value="<?= $row['address'] ?>" />
                          <input type="text" id="clcvg-<?= $row['id'] ?>" value="<?= $row['gst_no'] ?>" />
                          <input type="text" id="clcvps-<?= $row['id'] ?>" value="<?= $row['gst_supply'] ?>" />
                          </span>
                       
                         </td>
                       
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                    
                        
                        
                      </tbody>
                    </table>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

               

            </div>

        </div>

    </div>

</div>



<script src=" <?php echo url()?>bootstrap/js/script.js"></script>

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



function shipstate(str1)
{
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="<?=url()?>getvalue.php" //Edit this Line Ac to Your page
url=url+"?qry="+str1

xmlHttp.onreadystatechange=stateChanged1
xmlHttp.open("post",url,true)
xmlHttp.send(null)
}function stateChanged1()
{

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("shipstate").innerHTML=xmlHttp.responseText
 }

else
{
document.getElementById("shipstate").innerHTML="<img  src=<?=url()?>images/loader.gif height=30 />";
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
$(document).ready(function() {
	
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<tr><td><a class="remove_field btn btn-danger btn-xs" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td><td colspan="2"><input style="width:100%; border:none; height:100%" type="text" placeholder="Enter Services Name" name="services[]" /></td><td><textarea class="servicebox" placeholder="Services Description (Optional)" style="height:40px" name="description[]"></textarea></td><td ><input class="txtcal servicebox" type="text" placeholder="0.00"  name="price[]" onkeyup="butcl();" onclick="butcl();"  /></td></tr>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
	
        e.preventDefault(); $(this).parent('td').parent('tr').remove(); x--;
		calculateSum();
		
    })
});

</script>
<script>
function calculateSum() {

		var sum = 0;
		//iterate through each textboxes and add the values
		$(".txtcal").each(function() {

			//add only if the value is number
			if(!isNaN(this.value) && this.value.length!=0) {
				sum += parseFloat(this.value);
			}

		});
		//.toFixed() method will roundoff the final sum to 2 decimal places
		sgt=sum;
		cgt=sum;
		igt=sum;
		
		var gst_rate_inv = document.getElementById('select_gst_rate').value;
		
		cgt=(cgt/100)* gst_rate_inv;
		sgt=(sgt/100)* gst_rate_inv;
		
		igt=(igt/100)* (gst_rate_inv*2);
		
		$("#cgst_rate").html(gst_rate_inv);
		$("#sgst_rate").html(gst_rate_inv);
		$("#igst_rate").html(gst_rate_inv*2);
		
		ingst=0;
		$("#subt").html(sum.toFixed(2));
		$("#subt1").val(sum.toFixed(2));
		if($("#checkgst").is(':checked'))
    {
		$("#sgsttax").html(ingst.toFixed(2));
		$("#cgsttax").html(ingst.toFixed(2));
		$("#igsttax").html(igt.toFixed(2));
		
		$("#sgt1").val(ingst.toFixed(2));
		$("#cgt1").val(ingst.toFixed(2));
		$("#igt1").val(igt.toFixed(2));
		
		sum=sum+igt;
		$("#sum").html(sum.toFixed(2));
		$("#sum1").val(sum.toFixed(2));
		}  // checked
else
    {$("#sgsttax").html(sgt.toFixed(2));
		$("#cgsttax").html(cgt.toFixed(2));
		$("#igsttax").html(ingst.toFixed(2));
		sum=sum+sgt+cgt;
		$("#sum").html(sum.toFixed(2));
		
		
		$("#sgt1").val(sgt.toFixed(2));
		$("#cgt1").val(cgt.toFixed(2));
		$("#igt1").val(ingst.toFixed(2));
		
		$("#sum1").val(sum.toFixed(2));
		
		}
		
		
	}
</script>
<?php include('include/footer.php'); ?>