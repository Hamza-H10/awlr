<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


// Include necessary files
require '../vendor/autoload.php';  // Autoload files using Composer
require '../db.php';  // Include the database connection file

// Set the default timezone
date_default_timezone_set('Asia/Kolkata');

// Create a new Slim application
$app = new Slim\App();
$approot = "http://www.awlr.in";

// Login authentication endpoint
$app->post('/login', function (Request $request, Response $response) {
    // Parse the request body to get data
    $data = $request->getParsedBody();
    $objcon = new db();  // Create a new database connection object
    $salt1 = "qm&h*";
    $salt2 = "pg!@";

    // Check if required fields are present in the request
    if (isset($data['Email']) && $data['Email'] != '' && isset($data['Password']) && $data['Password'] != '' && isset($data['DeviceID']) && $data['DeviceID'] != '') {
        $email = $data['Email'];
        $password = $data['Password'];
        $deviceid = $data['DeviceID'];
        $date = date("Y-m-d H:i:s");

        // Check authentication using the authenticate method
        if (!$objcon->authenticate($email, $password)) {
            $res['status'] = 'error';
            $res['message'] = 'Authentication error. Please check your Email and Password.';
            return json_encode($res);
        } else {
            $res['status'] = 'success';
            $res['message'] = 'Login successfully';
            $res['session_id'] = hash('SHA1', "$salt1$date$salt2");
            $_SESSION['id'] = $res['session_id'];
            $u_id = $_SESSION['user_id'];

            // Update the device ID in the database
            $con = $objcon->connect();
            $sql = "UPDATE tbl_registration SET device_id = '$deviceid' WHERE id='$u_id'";
            $query_res = mysqli_query($con, $sql);

            // Check if the update was successful
            if ($query_res == TRUE)
                return json_encode($res);
            else {
                $res['status'] = 'error';
                $res['message'] = 'Could not update Device ID to the server.';
                return json_encode($res);
            }
        }
    } else {
        $res['status'] = 'error';
        $res['message'] = 'Please enter your Email, Password and DeviceID.';
        return json_encode($res);
    }
});

// User registration endpoint
$app->post('/registration', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $objcon = new db();
    $salt1 = "qm&h*";
    $salt2 = "pg!@";

    // Extract data from the request
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $pass = hash('SHA1', "$salt1$password$salt2");
    $phone = $data['phone'];
    $location = $data['location'];
    $token = hash('SHA1', "$email");
    $query = "SELECT `Email` FROM `tbl_registration` WHERE Email ='$email'";

    // Connect to the database
    $con = $objcon->connect();

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Check if the email is already registered
    if ($row['Email'] == $email) {
        $res['status'] = 'error';
        $res['message'] = 'Email already registered. Use forgot password or another email.';
        return json_encode($res);
    } else {
        // Generate a random OTP
        $otp = mt_rand(100000, 999999);
        $query = "INSERT INTO tbl_registration (`Name`, `Email`, `Password`, `Location`,`token`, `phone`, `otp`) VALUES ('$name','$email','$pass','$location','$token','$phone','$otp')";
        $result = mysqli_query($con, $query);

        // Check if the registration was successful
        if ($result == true) {
            $res['status'] = 'success';
            $res['message'] = 'User Registration Complete.';
            return json_encode($res);
        } else {
            $res['status'] = 'error';
            $res['message'] = 'There was an error in registering the user.';
            return json_encode($res);
        }
    }
});

//adding data to the particular device 
$app->get('/adddevicedata/{token}/{device_number}/{value1}/{value2}/{value3}', function (Request $request, Response $response, $args) {
    $objcon = new db();

    // Check if the token is present in the URL
    if (isset($args['token']) && $args['token'] != '') {
        $token = $args['token'];
    }
    // Authenticate using the token
    if (!$objcon->authenticate($token)) {
        $res['status'] = 'error';
        $res['message'] = 'Authentication error. Please check your access token.';
        $res['data'] = '';
        return json_encode($res);
    }

    // Check if required parameters are present in the URL
    if (isset($args['device_number']) && $args['device_number'] != '' && isset($args['value1']) && $args['value1'] != '' && isset($args['value2']) && $args['value2'] != '' && isset($args['value3']) && $args['value3'] != '') {
        $device_number = $args['device_number'];
        $value1 = $args['value1'];
        $value2 = $args['value2'];
        $value3 = $args['value3'];
    } else {
        $res['status'] = 'error';
        $res['message'] = 'Check required field(s).';
        $res['data'] = '';
        return json_encode($res);
    }

    // Connect to the database
    $con = $objcon->connect();

    // Check if the device number exists in the database
    $sql = "SELECT id FROM devices WHERE device_number = '$device_number' ";
    $query = mysqli_query($con, $sql);
    $output = mysqli_fetch_assoc($query);

    if (!empty($output)) {
        $device_id = $output['id'];
        $sql = "INSERT INTO `device_data` (device_id, value1, value2, value3, date_time) VALUES ($device_id,'$value1','$value2','$value3','" . date('Y-m-d H:i:s') . "')";
        $query = mysqli_query($con, $sql);

        if ($query == TRUE) {
            // If the data insertion is successful
            $res['status'] = 'success';
            $res['message'] = 'Data added successfully.';
            $res['data'] = '';
            return json_encode($res);
        } else {
            // If there is an error in data insertion
            $res['status'] = 'error';
            $res['message'] = 'There is an error occurred.';
            $res['data'] = '';
            return json_encode($res);
        }
    } else {
        // If the device does not exist
        $res['status'] = 'error';
        $res['message'] = 'Device does not exist.';
        $res['data'] = '';
        return json_encode($res);
    }
});

// Run the Slim application
$app->run();

