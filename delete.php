<?php
session_start();
include_once 'dbconfig.php';


$q=$_GET['id'];
$red=$_GET['red'];
	
	
	

	
	
					$stmt = $db->prepare("DELETE FROM loading_information WHERE id='$q'  ");
					
					if($stmt->execute())
					
					{$_SESSION['FLASH'] = "Bill No. ".$q." Deleted Successfully";}
					else{$_SESSION['FLASH'] = "Opps Somthing going wrong!";}
					
					
					
	?>
    
    <script>
window.location.href = '<?php echo $red ?>';
</script>
	
	
		
		
