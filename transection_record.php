<?php
session_start();
include_once 'dbconfig.php';


$q=$_GET['qry'];
	
	function bill_amount($token)
	{
		global $db;
		 
					   $stmt3 = $db->prepare("SELECT * FROM tbl_invoice_data where token='$token'");
			$stmt3->execute();
			while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
			{
				$val=$row3['total'];
                        
                        
						 }
		return $val;
		}
	
	?>
   
 <table id="datatables" class="table table-striped table-bordered dataTable" data-page-length='10'>
                    
                    
                    
                    
                      <thead>
                        <tr>
                        
                         <th >Sr No.</th>
                         
                           <th>Name</th>
                             <th>Mobile No.</th>
                             <th>Bill Amount</th>
                            <th>Payment</th>
                            
                            <th>Perform</th>
                        </tr>
                      </thead>


                      <tbody>
                       
                       
                      
                       
                       <?php 
					   $bill_amttmp='';
					  $rown=0;
					   $stmt = $db->prepare("SELECT * FROM tbl_invoice_to where type='1' and gst_no='$q' order by id desc ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$rown=$rown+1;
					  
					    ?>
                        
                        <tr>
                        
                         <td><?php echo $rown ?></td>
                           <td><?php echo $row['name'] ?></td>
                          
                           <td><?php echo $row['mobile'] ?></td>
                         <td><?=bill_amount($row['token']);?> <?php $bill_amttmp=$bill_amttmp+bill_amount($row['token']) ?></td>  
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
                         
                       </td>
                       
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                    
                        
                        
                      </tbody>
                      <tfoot>
            <tr>
                 <th colspan="3"><center>Total</center></th>
                         
                          
                            <th><?= $bill_amttmp?></th>
                            
                            <th colspan="2"></th>
            </tr>
            
        </tfoot>
                    </table>