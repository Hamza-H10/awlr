<?php
error_reporting(0);

	$db_host = "localhost";
	$db_name = "hostingm_jumbo";
	$db_user = "hostingm_ankit";
	$db_pass = "ankit@123";
	
	try{
		
		$db = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
?>
<?php
if(isset($_POST['btn']))
	{
		
		
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
		
		
		
		
		
		
		
$sup_bill_no=$_POST['bil_no'];
$reportingdate=$_POST['reportingdate'];
$unloading=$_POST['unloading'];
$damage=$_POST['damage'];
$actualamount=$_POST['actualamount'];
$billno=$_POST['billno'];
if($_POST['paid']==''){$paid='';}else{$paid=$_POST['paid'];}


if($_POST['supplementryneed']==''){$supplementryneed='';}else{$supplementryneed=$_POST['supplementryneed'];}
$supplementrybillno=$_POST['supplementrybillno'];

if($_POST['supplementrypaid']==''){$supplementrypaid='';}else{$supplementrypaid=$_POST['supplementrypaid'];}





	$stmt = $db->prepare("INSERT INTO supplementry (bill_id, report_date,unlode_date,damage,actual_ammount,bills_no,paid,supplementry_need,supplementry_billno,supp_paid) VALUES( :sup_bill_no, :reportingdate, :unloading, :damage, :actualamount, :billno, :paid, :supplementryneed, :supplementrybillno, :supplementrypaid)");
			
			
			
			$stmt->bindParam(":sup_bill_no",$sup_bill_no);
			$stmt->bindParam(":reportingdate",$reportingdate);
			$stmt->bindParam(":unloading",$unloading);
			$stmt->bindParam(":damage",$damage);
			$stmt->bindParam(":actualamount",$actualamount);
			
			$stmt->bindParam(":billno",$billno);
			$stmt->bindParam(":paid",$paid);
			$stmt->bindParam(":supplementryneed",$supplementryneed);
			$stmt->bindParam(":supplementrybillno",$supplementrybillno);
			
			$stmt->bindParam(":supplementrypaid",$supplementrypaid);
			
			
			
			$stmt->execute();
			
}

?>
<script>
window.location.href = 'show_bills.php?cid=<?php echo $sup_bill_no ?>';
</script>


