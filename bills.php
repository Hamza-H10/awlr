<?php
session_start();
error_reporting(0);

if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
}

include_once 'dbconfig.php';
 $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
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
$search=$_REQUEST['s'];
if(!$search==''){$search="%".$search."%";$sqry=" plant LIKE '$search'";}
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
                  <div class="col-md-12 " style="padding-bottom:10px">
                    <div class="col-md-6">
                    
                    <table cellspacing="5" cellpadding="5" border="0">
    <tbody><form method="get" action="bills.php"><tr>
        <td><strong>Minimum Date: </strong></td>        
        <td><input id="mindate"  name="min" type="text"></td>
    </tr>
    <tr>
        <td><strong>Maximum Date: </strong></td>
        <td><input id="maxdate"  name="max" type="text"></td>
      
    </tr>
     <tr>
        <td><strong>Search by Plant: </strong></td>
        <td><input id="maxdate"  name="s" type="text"></td>
      
    </tr>
    <tr>
        <td></td>
        <td><button type="submit">Search By Date</button></td>
       
    </tr> </form>
</tbody></table></div>
<div class="col-md-6">

</div></div>

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
     <form action="export_bill.php" method="post">
                    <table id="datatable-buttons" class="table table-striped table-bordered" data-page-length='100'>
                    
                    
                    
                    
                      <thead>
                        <tr>
                        <th >Select</th>
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
					   if($mind=='' and $maxd==''){
					   $stmt = $db->prepare("SELECT * FROM loading_information ");}else{
						    $stmt = $db->prepare("SELECT * FROM loading_information where ".$sqry." and date_search between '$mindq' AND '$maxdq'");
						   }
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				
					  
					    ?>
                        
                        <tr>
                        <td><input type="checkbox" name="selt[]" value="<?php echo $row['id'] ?>" /> <a style="float:right; padding:2px;" href="delete.php?id=<?php echo $row['id'] ?>&amp;red=<?php echo $url ?>"> <span class="glyphicon glyphicon-remove"></span></a> <a href="edit.php?id=<?php echo $row['id'] ?>" style="float:right; padding:2px;">
          <span   class="glyphicon glyphicon-pencil"></span>
        </a></td>
                          <td><a href="show_bills.php?cid=<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a></td>
                          
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
                        
                      </tbody>
                    </table>
                    <input type="submit" value="Export" />
                        </form>
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
   <script>
   
   </script>
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

<script>

	$( document ).ready(function() {
    

$('#dmsg').delay(5000).fadeOut('slow');


});
		
</script>
<style>
.inrsp{ margin:auto; padding:10px 15px; margin-top:5px; background-color:#00CC33; border-radius:4px; position:fixed}
</style>
<?php if(!empty($_SESSION['FLASH'])) {?>
<div id="dmsg" style="position:absolute; width:300px; height:auto; margin-left:40%; background-color: #FF9; padding:10px; top:55px; z-index:999999">
<center><?php echo $_SESSION['FLASH'] ?></center>
</div>
<?php }
unset($_SESSION['FLASH']);
?>

</body>
</html>