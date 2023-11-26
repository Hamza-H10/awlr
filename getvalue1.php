<?php
session_start();
include_once 'dbconfig.php';


$q=$_REQUEST['qry'];
$w=$_REQUEST['wry'];
$x=$_REQUEST['xry'];
	
	
	
	?>
	
                     
	<?php
	if($q=='Select Station To'){
	
					
					?>
                   <input class="form-control" name="amt" id="kotloading" placeholder="Ammount" type="text">
					
                   
                    <?php }else{ $stmt = $db->prepare("SELECT * FROM rate_list WHERE UNIT_NAME='$x' AND DC_NAME='$q' limit 1  ");
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
					
			{
						if($w=='6 TYRE'){$amount=$row['6t'];}
						else if($w=='10 TYRE'){$amount=$row['10t'];}
						else if($w=='24 FT CONTAINER'){$amount=$row['24c'];}
						else if($w=='28 FT CONTAINER'){$amount=$row['28c'];}
						else if($w=='32 FT CONTAINER'){$amount=$row['32c'];}
						else{echo 'Somthing going wrong' ;}
						
						?>
						
                        
                        <input class="form-control" name="amt" id="kotloading"  value="<?php echo $amount ?>" type="text">
				
						
						<?php
						}}?>
		
		
		
 <style>

  
 .rowa{ margin-top:1px; background-color:#efefef; border:solid 1px #aaa}
 </style>
 