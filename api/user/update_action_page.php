<?php
require_once("../dbcon.php");
if ($_POST) {
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$num = filter_var($_POST['num'], FILTER_SANITIZE_STRING);
	$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
	$sql = "UPDATE devices SET device_number = '$num', device_short_name = '$name' WHERE id=" . $id;
	$details = array();
	if (!$result = $conn->query($sql)) {
		echo $conn->error;
	} else {
		// header('Location: http://awlr.in/api/user/');
		header("Location: http://localhost/awlr/api/user/");
	}
}
