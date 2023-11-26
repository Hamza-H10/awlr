<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require '../vendor/autoload.php';
require '../db.php';

//session_start();
date_default_timezone_set('Asia/Kolkata');
$app = new Slim\App();
$approot = "http://www.awlr.in";


// login authendication
// code by Shashi prabha pandey [30-01-19]:
$app->post('/login', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $objcon = new db();
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
// check authentication
	if(isset($data['Email']) && $data['Email']!='' && isset($data['Password']) && $data['Password']!='' && isset($data['DeviceID']) && $data['DeviceID'] != '') {
        $email = $data['Email'];
        $password = $data['Password'];
        $deviceid = $data['DeviceID'];
        $date = date("Y-m-d H:i:s"); 

        if(!$objcon->authenticate($email, $password)){
            $res['status'] = 'error';
            $res['message'] = 'Authentication error. Please check your Email and Password.';
            return json_encode($res);
        }
        else{
            $res['status'] = 'success';
            $res['message'] = 'Login successfully';
            $res['session_id'] = hash('SHA1', "$salt1$date$salt2");
            $_SESSION['id'] = $res['session_id'];
            $u_id = $_SESSION['user_id'];

            $con = $objcon->connect();
            $sql = "UPDATE tbl_registration SET device_id = '$deviceid' WHERE id='$u_id'";
            $query_res = mysqli_query($con, $sql);
            if($query_res == TRUE)
                return json_encode($res);
            else {
                $res['status'] = 'error';
                $res['message'] = 'Could not update Device ID to the server.';
                return json_encode($res);
            }
        }
    }
    else {
        $res['status'] = 'error';
        $res['message'] = 'Please enter your Email, Password and DeviceID.';
        return json_encode($res);
    }
});

$app->post('/registration', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $objcon = new db();
    $salt1 = "qm&h*";
    $salt2 = "pg!@";

    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $pass = hash('SHA1', "$salt1$password$salt2");
    $phone = $data['phone'];
    $location = $data['location'];
    $token = hash('SHA1', "$email");
    $query = "SELECT `Email` FROM `tbl_registration` WHERE Email ='$email'";

    $con = $objcon->connect();

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result); 
    if($row['Email'] == $email) {
        $res['status'] = 'error';
        $res['message'] = 'Email already registered. Use forgot password or another email.';
        return json_encode($res);
    } 
    else {
        $otp = mt_rand(100000, 999999);
        $query = "INSERT INTO tbl_registration (`Name`, `Email`, `Password`, `Location`,`token`, `phone`, `otp`) VALUES ('$name','$email','$pass','$location','$token','$phone','$otp')";
        $result = mysqli_query($con, $query);

        if($result == true) {
            $res['status'] = 'success';
            $res['message'] = 'User Registration Complete.';
            return json_encode($res);
        }
        else{
            $res['status'] = 'error';
            $res['message'] = 'There was an error in registering the user.';
            return json_encode($res);
        }

    }

});


//add new data in table
// code by Shashi prabha pandey [31-01-19]:
$app->get('/adddevicedata/{token}/{device_number}/{value1}/{value2}/{value3}', function (Request $request, Response $response, $args) {
    $objcon = new db();
    // check authentication

    if(isset($args['token']) && $args['token']!=''){
	    $token = $args['token'];
    }
	if(!$objcon->authenticate($token)){
		$res['status'] = 'error';
		$res['message'] = 'Authentication error. Please check your access token.';
		$res['data'] = '';
		return json_encode($res);
	}
    if(isset($args['device_number']) && $args['device_number']!='' && isset($args['value1']) && $args['value1']!='' && isset($args['value2']) && $args['value2']!='' && isset($args['value3']) && $args['value3']!=''){
        $device_number = $args['device_number'];
	    $value1 = $args['value1'];
		$value2 = $args['value2'];
		$value3 = $args['value3'];
    }
    else {
       $res['status'] = 'error';
	   $res['message'] = 'check required field(s).';
	   $res['data'] = '';
	   return json_encode($res);
    }		

    $con = $objcon->connect();

	$sql = "SELECT id FROM devices WHERE device_number = '$device_number' ";
	$query = mysqli_query($con, $sql);
	$output = mysqli_fetch_assoc($query);
	//print_r($auth);
	$device_id = $output['id'];

	if(!empty($output)) {

        $sql = "INSERT INTO `device_data` (device_id, value1, value2, value3, date_time) VALUES ($device_id,'$value1','$value2','$value3','".date('Y-m-d H:i:s')."')";
        $query = mysqli_query($con, $sql);
        if($query == TRUE){
    		$res['status'] = 'success';
    		$res['message'] = 'Data added successfully.';
    		$res['data'] = '';
    		return json_encode($res);
        }
        else{
            $res['status'] = 'Error';
    		$res['message'] = 'There is an error occured.';
    		$res['data'] = '';
    		return json_encode($res);
    	}
	}
	else {
	    
	}
});


$app->run();
?>