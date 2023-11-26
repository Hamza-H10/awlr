<?php
 include('include/header.php');
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$stmtid = $db->prepare("SELECT * FROM tbl_setting where id=1");
$stmtid->execute();
			while($rowid = $stmtid->fetch(PDO::FETCH_ASSOC))
			{
			
						
						
						$details=unserialize($rowid['details']);
						$details_payment=unserialize($rowid['payment_details']);
						
							
						$image_url=$rowid['image_url'];
					
						
						}



?>

<style>
.add_field_button,.remove_field{ padding:5px}

h5{ font-size:12px !important}
table{ width:100%}
</style>

 <?php  
 $inn='';
		$bill_number=$_SERVER['QUERY_STRING'];			  
					   $stmtid = $db->prepare("SELECT * FROM tbl_invoice_data where token='$bill_number'");
			$stmtid->execute();
			while($rowid = $stmtid->fetch(PDO::FETCH_ASSOC))
			{
				$inn=$inn+1;
					  
					    ?>
                        <?php 
						$idnum='';
						$billdate='';
						$service='';
						$service=unserialize($service);
						$descr='';
						$descr=unserialize($descr);
						$price='';
						$price=unserialize($price);
						$sub='';
						$other='';
						$cgst='';
						$sgst='';
						$igst='';
						$igstchk='';
						$gtotal='';
						
						
						
						$idnum=$rowid['id'];
						$billdate=$rowid['bill_date'];
						$service=$rowid['service'];
						$service=unserialize($service);
						$descr=$rowid['descr'];
						$descr=unserialize($descr);
						$price=$rowid['price'];
						$price=unserialize($price);
						$sub=$rowid['sub'];
						$other=$rowid['other'];
						$cgst=$rowid['cgst'];
						$sgst=$rowid['sgst'];
						$igst=$rowid['igst'];
						$igstchk=$rowid['igstchk'];
						$gtotal=$rowid['total'];
						$reverse_charge=$rowid['reverse_charge'];
						
						
						}
						?>
                        <div class="body-container" id="page_content">
   <form method="post" enctype="multipart/form-data" action="insertdata.php" > 
  <div class=" ">

<!------head------->
<div class=" container">
 <div class="row">
 
 <div class=" col-xs-12">
 <table>
 <tr><td >
 <div class="col-xs-6"><img width="250px" src="<?=url()?>uploads/<?= $image_url ?>" class="img-responsive" /></div>
 </td>
 <td>
 <div class="col-xs-6">
 <table style="float:right">
 <tr>
 <td>Reference &nbsp;&nbsp;:</td>
 <td><?= $gst_invoice_config['bill_prefix']?>/17-18/<?= $idnum+$gst_invoice_config['bill_start_chng']
  ?></td>
 </tr>
 <tr>
 <td>Billing Date :</td>
 <td><?php echo $billdate ?>
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
                </td>
 </tr>
 </table>
 </div>
</td></tr> </table>
 </div>
 </div>
 
 </div>
 
</div>
<!------head close------->
<style>
.bbgwa{border-radius:3px;  background-color:#fff;box-shadow:0px 0px 1px #aaa; }
.dshb{border: 1px dotted #999999; border-bottom:none; border-top:none;}
.thcfw{border-bottom:solid 1px #ccc; background-color: #5cb85c; color:#FFFFFF; line-height:26px; text-align:center; border-top:2px solid rgb(8, 61, 95); box-shadow:0px 0px 4px #ccc; font-weight:600; text-shadow:0px 0px 4px #666 }

</style>
<!------company details------->

<div class=" container" style="margin-bottom:15px">
 <div class="row" >
  <?php 
 $varnnn='';
 
  
 ?>
 <div class="col-xs-4" style="float:left; width:33.33%"><table >
 <tr  class="thcfw">
 <td style="color:#FFF"><center>Our Information</center></td>
 </tr>
 <tr>
 <tr>
 

 


 <td><h5 style="text-transform:uppercase"><strong><?=$details['name']?></strong></h5></td>
 </tr>
 <tr>
 <td>
  <strong>Address</strong><br />
 <?=$details['address1']?> <br />
 <?=$details['address2']?><br />
 <?=$details['address3']?> 
 <br /><br />
 <strong>Contact No :</strong>  <?=$details['contact']?>
 </td>
 </tr>

 <tr>
 <td>
  <strong>GSTIN :</strong> <?=$details['gstin']?>
 </td>
 </tr>
 
 <tr>
 <td >
 <span ><strong >Paid  Under Reverse Charge :</strong> 
 <?php if($reverse_charge==1){echo 'YES';}else{echo 'NO';} ?></span>
 </td>
 </tr>
 
 </table></div>
 
 <div class="col-xs-4" style="float:left; width:33.33%">
 <?php $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where token='$bill_number' and type='1' ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$inn=$inn+1;
					  
					    $name=$row['name'];
						$address=$row['address'];
						$statein=$row['gst_state'];
						$mobilein=$row['mobile'];
						$gstin=$row['gst_no'];
						$sts=$row['gst_supply'];
						
						
						
						}
						
					   $stmtq = $db->prepare("SELECT * FROM sheet1 where Name_of_the_State='$statein'");
			$stmtq->execute();
			while($rowq = $stmtq->fetch(PDO::FETCH_ASSOC))
			{
				$inn=$inn+1;
					  
					   
						$stc=$rowq['State_Codes'];
						 
						}
						?>
                        
 <table >
 <tr  class="thcfw">
 <td style="color:#FFF"><center>Tax Invoice</center></td>
 </tr>
 <tr>
 <tr>
 

 


 <td><h5><strong style=" text-transform:uppercase"><?php echo $name ?></strong></h5></td>
 </tr>
 <tr>
 <td>
 <strong>Address</strong><br />
 <span style="text-transform:capitalize"><?php echo $address ?></span><br />
<br /> <span ><?php echo $statein.' ('.$stc.')' ?></span>
 <br /><br />
 <strong>Contact No :</strong> <?php echo $mobilein ?>
 </td>
 </tr>

<tr>
 <td>
 <strong>State Of Supply :</strong><?php echo $sts ?>
 </td>

 <tr>
 <td>
 <strong>GSTIN :</strong><?php echo $gstin ?>
 </td>
 </tr>
 </table>
 </div>
 
  <div class="col-xs-4" style="float:left; width:33.33%">
  <?php  $sel_view;
					   $inn=0;
					  $total=0;
					  
					   $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where token='$bill_number' and type='2' ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$inn=$inn+1;
					  
					    ?>
                        <?php $name=$row['name'];
						$address=$row['address'];
						
						if($row['gst_state']=='Select State'){
						}else{$statein=$row['gst_state'];}
						$mobilein=$row['mobile'];
						$gstin=$row['gst_no'];
						$sts=$row['gst_supply'];
						}
						?>
                        
                         <?php 
					  
					   $stmtq = $db->prepare("SELECT * FROM sheet1 where Name_of_the_State='$statein'");
			$stmtq->execute();
			while($rowq = $stmtq->fetch(PDO::FETCH_ASSOC))
			{
				$inn=$inn+1;
					  
					    ?>
                        <?php 
						$stc=$rowq['State_Codes'];
						
						}
						?>
  <table >
 <tr  class="thcfw">
 <td style="color:#FFFFFF"><center>Shipping To</center></td>
 </tr>
 <tr>
 <tr>
 

 


 <td><h5><strong style=" text-transform:uppercase"><?php echo $name ?></strong></h5></td>
 </tr>
 <tr>
 <td>
 <strong>Address</strong><br />
 <span style="text-transform:capitalize"><?php echo $address ?></span><br />
<br /> <span ><?php echo $statein.' ('.$stc.')' ?></span>
 <br /><br />
 <strong>Contact No :</strong> <?php echo $mobilein ?>
 </td>
 </tr>



<tr>
 <td>
 <strong>State Of Supply :</strong><?php echo $sts ?>
 </td>

 <tr>


 <tr>
 <td>
 <strong>GSTIN :</strong><?php echo $gstin ?>
 </td>
 </tr>
 </table>
  
 </div>
 
 
 <div class=" col-xs-12" style=" padding-bottom:10px; padding-top:15px; ">
 
 
 
 
 
 </div>
 
 </div>
 
</div>
<!------company details------->






<!------service product------->
<div class=" container">
 <div class="row">
 
 <div class=" col-xs-12">
<div style="border:1px solid #ccc; border-bottom:none;border-radius:5px 5px 0px 0px">
<table cellspacing="0" cellpadding="0"  width="100%" style=" border-radius:5px 5px 0px 0px; line-height:28px;  background-color:#333; font-size:14px; color:#FFF; text-align:center" >
  
  <tr style="text-align:center" >
    <td style="width:10%">Sr No.</td>
    
    <td style="width:50%; border-left:1px solid #ccc; border-right:1px solid #ccc">Type Of Supply</td>
    
    
   
    <td  style="width:20%;border-right:1px solid #ccc">Descripton</td>
    <td  style="width:20%"> Price</td>
   
   
   
  </tr>
  
  
</table>
 </div>
 <div>
 <style>
 .servicebox{ width:100%; border:none; text-align:center}
 .input_fields_wrap td{ border:1px solid #FFF}
 </style>
 <table cellspacing="0" cellpadding="0" class="input_fields_wrap"    width="100%" style="text-align:center; line-height:30px; background-color:#eee;  ">
 
 <?php
 
 $cro=count($service);
 for($i=0;$i<$cro;$i++)
 {
  ?>
 
 <tr style=" border-top:2px solid #FFF">
    <td style="width:10%"><?php echo ($i+1);?>.</td>
    
    <td style="width:50%;border-left:1px solid #fff; border-right:1px solid #fff" colspan="2"><?php echo $service[$i];
	 ?></td>
  
    <td style="width:20%;border-right:1px solid #fff"><?php echo $descr[$i];
	 ?></td>
    
    
    <td style="width:20%"><?php echo $price[$i];
	 ?></td>
    
  </tr>
  
  <?php } ?>
  
 </table>
 </div>
 
 
 
 
 </div>
 
 <span style="width:20%; text-align:center ">
 
 </span>
 <style>
 .bottomt td{ border:1px solid #FFF}
 </style>
 <div class="col-xs-12">
 <table cellspacing="0" cellpadding="0" border="0">
 <tr>
 <td style="width:60%"></td>
 <td style="width:40%">
 <table cellspacing="0" class="bottomt"  cellpadding="0" style=" float:right;  line-height:30px;   background-color:#eee; border:1px solid #FFF">
 
  <tr>
    <td style="width:20%; text-align:right "><strong>Sub Total :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><span id="subt"><?php echo ($sub-$other) ?></span>&nbsp;&nbsp;Rs.</td>
  </tr>
  <tr style="border-top:1px solid #FFF">
    <td style=" text-align:right;border-top:1px solid #FFF "><strong>Other Charges :&nbsp;</strong></td>
     <td style="width:20%; text-align:center;border-top:1px solid #FFF ">
     <span id="subt"><?php echo $other ?></span>&nbsp;&nbsp;Rs.
     </td>
  </tr>
  <?php if($igstchk==0) {?>
  <tr id="trcgst">
    <td style="width:20%; text-align:right "><strong>CGST(9%) :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><span id="cgsttax"><?php echo $cgst ?></span>&nbsp;&nbsp;Rs.</td>
  </tr>
  <tr id="trsgst" >
    <td style="width:20%; text-align:right "><strong>SGST(9%) :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><span id="sgsttax"><?php echo $sgst ?></span>&nbsp;&nbsp;Rs.</td>
  </tr>
  <?php }else{?>
  <tr id="trigst" >
    <td style="width:20%; text-align:right" ><strong>IGST(18%) :&nbsp;</strong>
    </td>
    <td style="width:20%; text-align:center; vertical-align:baseline "><span id="igsttax"><?php echo $igst ?></span>&nbsp;&nbsp;Rs.</td>
  </tr>
  <?php }?>
   <tr>
    <td style="width:20%; text-align:right " id="Outertd">
    <strong>TOTAL :&nbsp;</strong></td>
    <td style="width:20%; text-align:center "><strong><span id="sum"><?php echo $gtotal ?></span>&nbsp;&nbsp;Rs.</strong></td>
  </tr>
  
  
</table>
 </td>
 </tr>
 </table>
 

 </div>
 
 
 
 </div>
 <?php
 
 
						
							$number = $gtotal;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
						
						
						
						
 
  ?>
  <div style="text-transform:capitalize; background-color:#eee; line-height:30px; padding-left:15px"><?= $result.'Rupees Only/-' ?></div>
 <div style="border-bottom:2px  solid #666666" >
 <h3>Payment Information</h3>
 </div>
 <table>
 <tr>
 <td >&nbsp;</td>
 </tr>
 <?php
 foreach($details_payment as $pay_detail)
 {
	 echo '<tr><td>'.$pay_detail.'</td></tr>';
	 }
  ?>
 
 
 </table>
 <div style="text-align:center; ">
 
 <p style="font-size:20px; font-weight:bold; margin:0px; padding:0px; margin-top:40px; font-family: 'Times New Roman', Times, serif">Thank You!</p>
 
 <p style="font-weight:bold; font-size:10px; margin:0px; padding:0px">In case of any querries concerning this invoice, please contact</p>
 <p style="font-size:10px;">* This is a system generated invoice, no signature required.</p>
 </div>
</div>
<!------service product close------->

</div>
</form>
</div>
</div>


</div>

<br />
</div>



<?php include('include/footer.php'); ?>