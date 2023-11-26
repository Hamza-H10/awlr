<?php
session_start();
include_once 'dbconfig.php';


$q=$_GET['qry'];
	
	
	
	?>
   
	<?php
	
	
					$stmt = $db->prepare("SELECT State_Codes from  sheet1 WHERE  	Name_of_the_State='$q'  ");
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
					
			{
					?>
                    
                  <?php echo $row['State_Codes'] ?>
                    
                    <?php }?>
                    
