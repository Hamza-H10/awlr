<?php
session_start();
include_once '../dbconfig.php';
 ?>



                       
                       
                      
                       
                       <?php 
					  $rown=0;
					   $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type='1' order by id desc ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$rown=$rown+1;
					  
					    ?>
                        
                        <tr>
                        
                         <td style="width:10%"><?php echo $rown ?></td>
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
                         <a onclick="delete_bill('<?=$row['token']?>');">
                         <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button>
                         </a>
                         </td>
                       
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                    
                        
                     
 
 