
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
$search=$_REQUEST['s'];
if(!$search==''){$search="%".$search."%";$sqry="WHERE plant LIKE '$search'";}
$stmt4 = $db->prepare("SELECT id FROM bill_no  where cid= '$sel_view'");
			$stmt4->execute();
			$count = $stmt4->rowCount();
			if($count=='0'){
$stmt1 = $db->prepare("INSERT INTO bill_no(cid) VALUES('$sel_view')");
$stmt1->execute();
}
$stmt2 = $db->prepare("SELECT id FROM bill_no  where cid= '$sel_view'");
			$stmt2->execute();
while($row3 = $stmt2->fetch(PDO::FETCH_ASSOC))
			{$bill_n=$row3['id'];}
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
<div class="">
  
  
  <div class=" container-fluid">


<div class="col-md-12 col-sm-12 col-xs-12" id="content">
                <div class="">
                 
                  <div class="">
     
                    
                    
                    
                    
                    <table cellspacing="0" cellpadding="0" border="1" width="100%" >
  <col span="11" />
  <tr height="21">
    <td colspan="11" height="21" ><center><textarea  draggable="false"     style="background-color:transparent; width:100%; border:none;text-align: center;height: 30px;font-size: initial;" >Dayal Freight Movers</textarea></center></td>
  </tr>
  <tr height="21">
    <td colspan="11" height="21" ><center>Address: 3b Dada Nagar Kanput. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; contact Details:9793023111</center></td>
  </tr>
  <tr height="36">
    <td colspan="2" height="36" >Company&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    :</td>
    <td colspan="5" ><textarea  draggable="false"     style="background-color:transparent; width:100%; border:none;height: 20px;" >Parle Products PVT LTD / Parle Biscuits PVT LTD</textarea></td>
    <td>BILL    NO&nbsp;&nbsp;&nbsp; :</td>
    <td colspan="3" width="192"><?php echo $bill_n; ?></td>
  </tr>
  <tr height="36">
    <td colspan="2" height="36" >Source-    From&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
    <td colspan="5" ><textarea  draggable="false" id="destinationTextField" class='copyText'   style="background-color:transparent; width:100%; border:none;height: 20px;" >AJMER FOOD PRODUCTS, AJMER</textarea></td>
    <td >DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    :</td>
    <td colspan="3" ><?php echo date('d/m/'.'20'.'y'); ?></td>
  </tr>
  <tr height="21">
    <td colspan="2" height="21" >Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    :</td>
    <td colspan="5" ><textarea  draggable="false"     style="background-color:transparent; width:100%; border:none;height: 20px;" >C001</textarea></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr height="53">
    <td height="53">Vendore    Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
    <td >&nbsp;</td>
    <td colspan="5" align="right"><textarea  draggable="false"     style="background-color:transparent; width:100%; border:none;height: 20px;" >600000011</textarea></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr height="42">
    <td height="42">S.No</td>
    <td >From</td>
    <td >To</td>
    <td >PO Number</td>
    <td >STO Number</td>
    
    <td >GAN Number</td>
    <td >Unique    Number</td>
    <td >Number of boxes</td>
    <td >KOT</td>
    <td >Vechile    Type</td>
    <td >Freight</td>
  </tr>
  
  
  
  
    <?php  $sel_view;
					   $inn=0;
					  $total=0;
					  
					   $stmt = $db->prepare("SELECT * FROM loading_information where id in($sel_view) ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$inn=$inn+1;
					  
					    ?>
                        
                        <tr id="" >
                        
                       
                          <td><?php echo $inn ?></td>
                          
                          <td ><textarea  draggable="false"  id="destinationTextField" class='copyText'   style="background-color:transparent; width:100%; border:none" >AJMER FOOD PRODUCTS, AJMER</textarea> </td>
                          
                           <td><?php echo $row['stationto'] ?></td>
                          
                            <td><?php echo $row['pon'] ?></td>
                          
                          <td><?php echo $row['stnno'] ?></td>
                          
                         
                         <td><?php echo $row['gann'] ?></td>
                          
                           <td><?php echo $row['unin'] ?></td>
                           <td><?php echo $row['noofboxes'] ?></td>
                          
                          
                          
                          
                         
                          <td><?php echo $row['kotloading'] ?></td>
                          <td><?php echo $row['trucktype'] ?></td>
                          
                           <td><?php echo $row['amt'] ?></td>
                        
                          
                         
                         
                          
                          
                    </tr>
                    
                        <?php 
						$total=$total+$row['amt'];
						
						
						}
						
						
						
						
							$number = $total;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => 'zero', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
						
						
						
						
						
						
						?>
                        
  
  
  
  
  <tr height="21">
    <td colspan="10" height="21" width="640">Total: &nbsp;<strong><?php if(!empty($result)){echo $result . "Rupees Only/-";} ?></strong></td>
    <td width="64"><?php echo $total; ?></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
                       
                       
                      
                       
                     
                     
                   
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
<script>

	$( document ).ready(function() {
    

$('#dmsg').delay(5000).fadeOut('slow');


});
		
</script>
<style>
.inrsp{ margin:auto; padding:10px 15px; margin-top:5px; background-color:#00CC33; border-radius:4px; position:fixed}
</style>
<?php if(!empty($_SESSION['FLASH'])) {?>
<?php }
unset($_SESSION['FLASH']);
?>
<script>


      $(document).ready(function(){
          
      var pdf = new jsPDF('p', 'pt', 'letter');
pdf.addHTML($('#content').html(), function () {
    pdf.save('Test.pdf');
});
          
    $('.copyText').on('keyup change paste', function(e){
        $('.copyText').val($(this).val())
    });
});
</script>




</body>
</html>