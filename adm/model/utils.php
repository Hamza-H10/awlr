<?php

session_start();
$salt1 = "qm&h*";
$salt2 = "pg!@";
$app_root_url = "https://datadigger.co.in/";

if (isset($_SESSION['userid']))
{
    $logged_in = TRUE;
    $session_user_id = $_SESSION['userid'];
    $session_user_type = $_SESSION['usertype'];
    // $session_device_id = $_SESSION['deviceid'];
}
else $logged_in = FALSE;

function getValue($value_name, $required = true, $default = null) {
    if (!empty($_REQUEST[$value_name])) {
        return filter_var($_REQUEST[$value_name], FILTER_SANITIZE_STRING);
    } 
    else {  
        if($required) {
            http_response_code(400);

            // tell the user no products found
            echo json_encode(
                array("message" => "Required parameter '$value_name'.")
            );
            die();
        }
        else {
            return $default;
        }
    }
}

