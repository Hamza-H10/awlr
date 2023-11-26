<?php
session_start();
include_once '../dbconfig.php';


$qry=$_GET['qry'];	
					
	
	
	if($qry=="delete"){
		
		$id=$_GET['id'];
		$stmt = $db->prepare("DELETE FROM tbl_invoice_to WHERE token='$id'  ");
					
					if($stmt->execute())
					
					{
						
				$stmt = $db->prepare("DELETE FROM tbl_invoice_data WHERE token='$id'  ");		
					if($stmt->execute())
					
					{
						$stmt = $db->prepare("DELETE FROM tbl_payment WHERE token='$id'  ");		
					if($stmt->execute()){
						
						echo 'Bill Deleted Successfully';
						
						}
						
						}	
						
		}
					
		
		
		}

	
					
	?>
    
   
	
	
		
		
