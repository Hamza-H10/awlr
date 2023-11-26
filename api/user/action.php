<?php
session_start();
$action = filter_var($_GET['action'], FILTER_SANITIZE_STRING);
$user_id = filter_var($_GET['user'], FILTER_SANITIZE_STRING);
$device_id = filter_var($_GET['device'], FILTER_SANITIZE_STRING);

switch($action) {
	case "updatedevice":
		updatedevice($user_id,$device_id);
		break;
	default:
		return 0;
}

function updatedevice($userid,$deviceid){
	require_once("../dbcon.php");
	$sql="update devices set user_id=".$userid." where id=".$deviceid;
	$details = array();
	if(!$result = $conn->query($sql)){
		echo $conn->error;
	}
	else
	{
		echo 1;

	}
}

?>