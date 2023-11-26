<?php include('include/header.php'); 

if($_POST){
	
	$password=md5($_POST['password']);
	
	$stmtpas = $db->prepare("UPDATE tbl_users  SET user_password=:pass where user_id=".$_SESSION['user_session']);
			$stmtpas->bindParam(":pass",$password);
			
			
			if($stmtpas->execute())
	{$_SESSION['FLASH']= "Your  Password Changed  Successfully";
		}else{$_SESSION['FLASH']="OOps Somthing Going Wrong!";}
		
		
		
	
	}
	function flash_message(){
		$content='';
		if(isset($_SESSION['FLASH'])){
		$content=' <style>
  
  
  #flash_msg {
    -moz-animation: cssAnimation 0s ease-in 5s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 5s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 5s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 5s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}
@keyframes cssAnimation {
    to {
        width:0;
        height:0;
        overflow:hidden;
    }
}
@-webkit-keyframes cssAnimation {
    to {
        width:0;
        height:0;
        visibility:hidden;
    }
}
  
  </style>';
		$content.='<div id="flash_msg" style="">
	<center>'.$_SESSION['FLASH'].'</center>
</div>';
	}
	unset($_SESSION['FLASH']);
return $content;
		}
?>
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 


  <style>
  .cwhite{ color:#FFFFFF}
  
 
  
  </style>
<div class="body-container">
<?php
$stmtid = $db->prepare("SELECT * FROM tbl_users WHERE user_id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
 ?>
<div class="container">
  <div class="row" >
  <div class="col-md-12" style="margin-top:15px">

<?= flash_message()?>



<center><h2 style="text-transform:capitalize"><?= $row['user_name']; ?></h2></center>
<center>
<style>
td{ padding:5px 15px}
</style>
<table  style="width:100%; max-width:500px; line-height:30px; background-color: #00993344; ">

<tr>
<td width="40%"><strong>User Type : </strong></td>
<td width="20%"></td>
<td><?php if($row['role']==1){echo'Admin User';} else{echo 'Normal User';} ?></td>
</tr>
<tr>
<td><strong>User Email : </strong></td>
<td width="40%"></td>
<td><?= $row['user_email']; ?></td>
</tr>
<tr>
<td><strong>Contact Number : </strong></td>
<td></td>
<td><?= $row['mobile']; ?></td>
</tr>
<tr>

<td colspan="3">
<form method="post" action="">
<center><label>Change Password</label></center>
<div class="form-group" style="margin-top:5px">
        <input name="password" class="form-control titleModal" placeholder="New Password" required data-placement="left"  title="Change Your Current Password" type="password" style="text-align:center" autocomplete="on ">
       
        </div>
        <div class="form-group" style="margin-top:5px">
        <center><input type="submit" class="btn btn-success" /></center>
       
        </div>
        </form>
        </td>
</td>

</tr>

</table>

</center>
</div>
  </div>

</div>

<div class="panel-footer" style="position: fixed;
width: 100%;
bottom: 0px;">

</div>
</div>

<?php include('include/footer.php'); ?>