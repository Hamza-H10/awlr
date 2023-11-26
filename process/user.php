<?php
session_start();
include_once '../dbconfig.php';


$qry=$_GET['qry'];
if($qry=="update")
{
	$id=$_GET['id'];
	$name=$_GET['name'];
	$email=$_GET['email'];
	$mobile=$_GET['mobile'];
	$role=$_GET['role'];
	
	$stmt = $db->prepare("UPDATE tbl_users  SET user_name=:name, user_email=:email, mobile=:mobile, role=:role where user_id='$id' ");
			$stmt->bindParam(":name",$name);
			$stmt->bindParam(":email",$email);
			$stmt->bindParam(":mobile",$mobile);
			$stmt->bindParam(":role",$role);
			
			
	if($stmt->execute())
	{
	if (!file_exists('../doc/'.$email)) {
    mkdir('../doc/'.$email, 0777, true);
}
	echo "User <b>".$name."</b> Updated Successfully";
		}else{echo"User <b>".$name."</b> Not Updated Successfully<br> Somthing Going Wrong!";}
	
	}
	
	if($qry=="create"){
		
		$password=md5($_GET['password']);
		
	$name=$_GET['name'];
	$email=$_GET['email'];
	$mobile=$_GET['mobile'];
	$role=$_GET['role'];
	
		
		$stmt = $db->prepare("INSERT INTO tbl_users(user_name,user_email,mobile,role,user_password) VALUES(:name, :email, :mobile, :role,:password)");
			$stmt->bindParam(":name",$name);
			$stmt->bindParam(":email",$email);
			$stmt->bindParam(":mobile",$mobile);
			$stmt->bindParam(":role",$role);
			$stmt->bindParam(":password",$password);
			
			if($stmt->execute())
	{ 
	if (!file_exists('../doc/'.$email)) {
    mkdir('../doc/'.$email, 0777, true);
}
	
	echo "User <b>".$name."</b> Added  Successfully";
	
	
	$to = $email;
$subject = "Automatic Water Level Recorder Account Detail";

$message = "
<html>
<head>
<title>Account Detail</title>
</head>
<body>
<p>Your Account Login Detail</p>
<p>User ID : <b>".$email."</b></p>
<p>Password: <b>".$_GET['password']."</b></p>

</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@awlr.in>' . "\r\n";


mail($to,$subject,$message,$headers);
	
	
	
	
	
	
		}else{echo"User <b>".$name."</b> Not Added Successfully<br> Somthing Going Wrong!";}
		
		
		}
	
	
	if($qry=="delete"){
		
		$id=$_GET['id'];
		$stmt = $db->prepare("DELETE FROM tbl_users WHERE user_id='$id'  ");
					
					if($stmt->execute())
					
					{echo "User Deleted  Successfully";
		}else{echo"User  Not Deleted Successfully<br> Somthing Going Wrong!";}
					
		
		
		}

function do_sms($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tbl_invoice_to where id='$id' and type='1' ");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				//$inn=$inn+1;
					  
					    $namein=$row['name'];
						//$address=$row['address'];
						//$statein=$row['gst_state'];
						$mobilein=$row['mobile'];
						//$gstin=$row['gst_no'];
						//$sts=$row['gst_supply'];
						$bill_token=$row['token'];
						
						
						}
						
						
						$stmt1 = $db->prepare("SELECT * FROM tbl_invoice_data where token='$bill_token'  ");
			$stmt1->execute();
			while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
			{
				//$inn=$inn+1;
					  
					    $bill_total=$row1['total'];
						
	$bill_services=unserialize($row1['service']);
	$bill_services_count=count($bill_services);
	if($bill_services_count>1){
		
		$service=$bill_services[0].' and '.$bill_services_count.' more services';
		}
		else{
			
			$service=$bill_services[0];
			
			}
						}
	
//error_reporting(0);
//$cname = $_POST[name];
//$emailid = $_POST[email];
//$mobileno = $_POST[mobile];
//$subjects = $_POST[subject];


$mobileNumber = $mobilein;

//$mobileNumber = '9560112346';


$senderId = "GSAinv";
$crme = 'Hello
'.$namein.' Bill of Rs '.$bill_total.' has been issued  for '.$service.'

'.' Thank You,
 CA Ashok Garg';
$message = urlencode($crme);

$route = 4;

//Prepare you post parameters
$postData = array(
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

$url="http://login.bulksms.bz/api/v2/sendsms";


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_HTTPHEADER => array(
        "authkey:  2533AJLrRfvx4iH589b0094 ",
        "content-type: multipart/form-data"
    ),
));

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
	
	}
	
if($qry=="sms"){
	
	$id=$_GET['id'];
	do_sms($id);
	}
					
	?>
    
    
	
		
		
