<?php
session_start();
error_reporting(0);

if (isset($_GET['cid'])) {
		$sel_view = ($_GET['cid']);}
		else{$sel_view = 'null';}

if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
}

include_once 'dbconfig.php';

$stmt = $db->prepare("SELECT * FROM tbl_users WHERE user_id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$mind='';
$maxd='';

$mind=$_GET['min'];

$mindx=explode('/',$mind);
$mindq=$mindx[2].$mindx[1].$mindx[0];
$maxd=$_GET['max'];
$maxdx=explode('/',$maxd);
$maxdq=$maxdx[2].$maxdx[1].$maxdx[0];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>invoice system</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link href="style.css" rel="stylesheet" media="screen">

 <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

</head>
<style>
#datatable-buttons_filter{ float:right}
</style>
<body style=" background-color:#fafafa">

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Billing System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="bills.php">Invoices</a></li>
            <li><a href="home.php">Create Invoices</a></li>
            <li><a href="#">User</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $row['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    
<div class="body-container">


<div class=" container-fluid">


<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                                        <script type="text/javascript">
        $(function () {
            $('#mindate').datepicker({
                inline: true,
				autoclose: true,
				format:'dd/mm/yyyy' ,
                sideBySide: true
            });
        });
    </script>
     <script type="text/javascript">
        $(function () {
            $('#maxdate').datepicker({
                inline: true,
				autoclose: true,
				format:'dd/mm/yyyy' ,
                sideBySide: true
            });
        });
    </script> 
     
                    <table id="datatable-buttons" class="table table-striped table-bordered" data-page-length='100'>
                    
                    
                    
                    
                      <thead>
                        <tr>
                        
                         <th >Sr<br /> No.</th>
                         
                           <th>STN No.</th>
                             <th>Po Number</th>
                            <th>GAN Number</th>
                            <th>Number of boxes</th>
                            <th>Unique Number</th>
                          <th>STN Date</th>
                          
                         <th>Destination</th>
                          <th>Vehicle Type</th>
                          <th>Plant Name</th>
                          
                         
                          <th>Kot Carried</th>
                           <th>Basic Freight</th>
                            <th>Weight of boxes</th>
                            <th>Amount</th>
                            
                           
                          
                         
                           
                            
                           
                            <th>Remarks</th>
                        </tr>
                      </thead>


                      <tbody>
                       
                       
                      
                       
                       <?php 
					  
					   $stmt = $db->prepare("SELECT * FROM loading_information where id='$sel_view' ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				
					  
					    ?>
                        
                        <tr>
                        
                           <td><?php echo $row['id'] ?></td>
                          
                           <td><?php echo $row['stnno'] ?></td>
                            <td><?php echo $row['pon'] ?></td>
                        <td><?php echo $row['gann'] ?></td>
                         <td><?php echo $row['noofboxes'] ?></td>
                        <td><?php echo $row['unin'] ?></td>
                          <td><?php echo $row['dateofloading'] ?></td>
                          
                         <td><?php echo $row['stationto'] ?></td>
                           <td><?php echo $row['trucktype'] ?></td>
                          <td><?php echo $row['plant'] ?></td>
                          
                          
                         
                          <td><?php echo $row['kotloading'] ?></td>
                          <td><?php echo $row['amt'] ?></td>
                          <td><?php echo $row['weightloading'] ?></td>
                           <td><?php echo $row['amt'] ?></td>
                        
                          
                         
                          
                         
                          <td><?php echo $row['remarks'] ?></td>
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                     <?php 
					  
					   $stmt1 = $db->prepare("SELECT * FROM supplementry where bill_id='$sel_view' ");
			$stmt1->execute();
			while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
			{
				
					  
					    ?>   
                        
                        
                         <tr>
                        <td>Supplementry Bill</td>
                          <td>Reporting Date: <?php echo $row1['report_date'] ?></td>
                           <td>Unloading Date: <?php echo $row1['unlode_date'] ?></td>
                          <td>Damage: <?php echo $row1['damage'] ?></td>
                          
                         <td>Actual Ammount: <?php echo $row1['actual_ammount'] ?></td>
                           <td>Bill No: <?php echo $row1['bills_no'] ?></td>
                          <td>Paid: <?php echo $row1['paid'] ?></td>
                          
                          
                         
                          <td>Supplementry Need: <?php echo $row1['supplementry_need'] ?></td>
                          <td>Supplementry Billno: <?php echo $row1['supplementry_billno'] ?></td>
                          <td>Supplementry Paid: <?php echo $row1['supp_paid'] ?></td>
                        
                          
                         
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                         
                          <td></td>
                          
                        </tr>
                        <?php }?>
                        
                        
                        
                      </tbody>
                    </table>
     <div class="form-group">
               <label>Supplementry Bill :</label> <input type="checkbox" name="mycheckbox" id="mycheckbox" value="0" />
                </div>
     <script type="text/javascript">
$('#mycheckbox').change(function() {
    $('#divsup').toggle();
});
</script>   
      
     <div class="col-md-3" id="divsup" style=" display:none">
     <form method="post" action="insertsup.php">
 <div class="col-md-12">
 <div class="row  panel panel-default">
 <div class="panel-heading">
							<h4 class="float-left">Supplementry Information</h4>
							
							<div class="clear"></div>
				</div>
 <div class="col-md-12 panel-body form-group form-group-sm ">
 <script type="text/javascript">
        $(function () {
            $('#datetimepicker13').datepicker({
                inline: true,
				autoclose: true,
				format:'dd/mm/yyyy' ,
                sideBySide: true
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker14').datepicker({
                inline: true,
				autoclose: true,
				format:'dd/mm/yyyy' ,
                sideBySide: true
            });
        });
    </script>
 
 <div class="form-group">
 <input type="text" class="form-control" name="bil_no" value="<?php echo $sel_view ?>" style=" display:none"  />
					<input type="text" class="form-control" name="reportingdate" id="datetimepicker13" placeholder="Reporting Date"  />
				</div>
                  <div class="form-group">
					<input type="text" class="form-control" name="unloading" id="datetimepicker14" placeholder="Unloading Date"  />
				</div>
                <div class="form-group">
					<input type="text" class="form-control" name="damage" id="damage" placeholder="Damage" />
				</div>
                <div class="form-group">
					<input type="text" class="form-control" name="actualamount" id="actualamount" placeholder="Actual Amount"  />
				</div>
                
               
                
               

				
                
                <div class="form-group">
					<input type="text" class="form-control" name="billno" id="billno" placeholder="Bill No."  />
				</div>   
                
                 <div class="form-group">
                 <label>Paid: </label> 
					<span class="pull-right"><input type="radio"  value="Yes" name="paid" id="paid"  /> Yes
                    <input type="radio"  value="No" name="paid" id="paid"  /> No</span>
                    
				</div>   
                
                
                <div class="form-group">
                 <label>Supplementry Need: </label> 
					<span class="pull-right"><input type="radio"  value="Yes" name="supplementryneed" id="supplementryneed"  /> Yes
                    <input type="radio"  value="No" name="supplementryneed" id="supplementryneed"  /> No</span>
                    
				</div>   
                
                <div class="form-group">
					<input type="text" class="form-control" name="supplementrybillno" id="supplementrybillno" placeholder="Supplementry Bill No."  />
				</div>    
                
                <div class="form-group">
                 <label>Supplementry Paid: </label> 
					<span class="pull-right"><input type="radio"  value="Yes" name="supplementrypaid" id="supplementrypaid"  /> Yes
                    <input type="radio"  value="No" name="supplementrypaid" id="supplementrypaid"  /> No</span>
                    
				</div>   
                
                
                
                </div>
               
              </div>
                </div>
                
         <button class="btn btn-success" style="margin-top:10px; " name="btn" id="btn"><b>Submit</b></button> </div>          
     </form>        </div>
     
     
     
                  </div>
                </div>
              </div>
<script>



  // Sort immediately with columns 0 and 1
 
 
 
  
  

</script>

</div>
</div>

</div>
</div>


</div>

</div>

  <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
   
    <!-- NProgress -->
   
    <!-- iCheck -->
    
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>



    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


<!-- Include Date Range Picker -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
</body>
</html>