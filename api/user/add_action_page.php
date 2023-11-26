<?php
require_once("../dbcon.php");

//print_r($_POST); exit();
if($_POST){
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$num = filter_var($_POST['num'], FILTER_SANITIZE_STRING);
$sql = "INSERT INTO devices (device_number, device_short_name)
VALUES ('$num', '$name')";
	$details = array();
	if(!$result = $conn->query($sql)){
		echo $conn->error;
	}
	else
	{
		header('Location: index.php'); 
	}	
}


?>