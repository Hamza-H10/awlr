
<?php
session_start();
include_once 'dbconfig.php';
if(isset($_POST['sub']))
	{
try{		
	
	 $bill_number=$_SERVER['QUERY_STRING'];
		
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


$namea='';
$mobilea='';
$gstnoa='';
$gststatea='';
$gstsupplya='';
$emaila='';
$pana='';
$addressa='';
$typea='';
$tokena='';

		


		
$name=$_POST['in_name'];
$mobile=$_POST['in_mobile'];
$gstno=$_POST['in_gst'];
$gststate=$_POST['in_state'];
$gstsupply=$_POST['in_place_supply'];
$email=$_POST['in_email'];
$pan=$_POST['in_pan'];
$address=$_POST['in_address'];




$namea=$_POST['ad_name'];
$mobilea=$_POST['ad_mobile'];
$gstnoa=$_POST['ad_gst'];
$gststatea=$_POST['ad_state'];
$gstsupplya=$_POST['ad_place_supply'];
$emaila=$_POST['ad_email'];
$pana=$_POST['ad_pan'];
$addressa=$_POST['ad_address'];

		
		
		



	$stmt = $db->prepare("UPDATE tbl_invoice_to  SET name=:name,mobile=:mobile,gst_no=:gst_no,gst_state=:gst_state,gst_supply=:gst_supply,email=:email ,pan_number=:pan_number,address=:address where token='$bill_number' and type=1");
			$stmt->bindParam(":name",$name);
			$stmt->bindParam(":mobile",$mobile);
			$stmt->bindParam(":gst_no",$gstno);
			$stmt->bindParam(":gst_state",$gststate);
			$stmt->bindParam(":gst_supply",$gstsupply);
			$stmt->bindParam(":email",$email);
			$stmt->bindParam(":pan_number",$pan);
			$stmt->bindParam(":address",$address);
			
			
			
			
			$stmt->execute();
			
			
			
			
			
			$stmt1 = $db->prepare("UPDATE tbl_invoice_to  SET name=:name,mobile=:mobile,gst_no=:gst_no,gst_state=:gst_state,gst_supply=:gst_supply,email=:email ,pan_number=:pan_number,address=:address where token='$bill_number' and type=2");
			$stmt1->bindParam(":name",$namea);
			$stmt1->bindParam(":mobile",$mobilea);
			$stmt1->bindParam(":gst_no",$gstnoa);
			$stmt1->bindParam(":gst_state",$gststatea);
			$stmt1->bindParam(":gst_supply",$gstsupplya);
			$stmt1->bindParam(":email",$emaila);
			$stmt1->bindParam(":pan_number",$pana);
			$stmt1->bindParam(":address",$addressa);
			
			
			
			
			
			
			$stmt1->execute();
			
	
	
			
$services=serialize($_POST['services']);
//print_r($_POST['services']);		
$description=serialize($_POST['description']);		
$price=serialize($_POST['price']);		
$sub_total=$_POST['sub_total'];	
$other_charges=$_POST['other_charges'];	
$invoice_cgst=$_POST['invoice_cgst'];	
$invoice_sgst=$_POST['invoice_sgst'];	
$invoice_igst=$_POST['invoice_igst'];
$reverse_charge='';
if(isset($_POST['reverse_charge'])){
$reverse_charge=$_POST['reverse_charge'];}
$igstchk=0;
	if(isset($_POST['igst'])){
$igstchk=$_POST['igst'];}

	
$invoice_total=$_POST['invoice_total'];
$compc=date('20'.'y'.'m'.'d');
$billingdate=$_POST['billingdate'];
	

$stmt2 = $db->prepare("UPDATE tbl_invoice_data SET service=:services,descr=:description,price=:price,sub=:sub_total,other=:other_charges,cgst=:invoice_cgst ,sgst=:invoice_sgst,igst=:invoice_igst,igstchk=:igstchk,total=:invoice_total,bill_date=:billingdate,reverse_charge=:rev where token='$bill_number'");
			$stmt2->bindParam(":services",$services);
			$stmt2->bindParam(":description",$description);
			$stmt2->bindParam(":price",$price);
			$stmt2->bindParam(":sub_total",$sub_total);
			$stmt2->bindParam(":rev",$reverse_charge);
			
			$stmt2->bindParam(":other_charges",$other_charges);
			$stmt2->bindParam(":invoice_cgst",$invoice_cgst);
			$stmt2->bindParam(":invoice_sgst",$invoice_sgst);
			$stmt2->bindParam(":invoice_igst",$invoice_igst);
			
			$stmt2->bindParam(":igstchk",$igstchk);
			$stmt2->bindParam(":invoice_total",$invoice_total);
			
			$stmt2->bindParam(":billingdate",$billingdate);
			
			
			
			
			
			$stmt2->execute();			
			
			
			}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}

?>
<script>
window.location.href = 'view-invoice.php?<?= $bill_number ?>';
</script>


