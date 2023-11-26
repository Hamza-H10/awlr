<?php
require_once("../dbcon.php");
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    $sql="delete from device_data where id=".$id;
    $details = array();
if(!$result = $conn->query($sql)){
	echo $conn->error;
}
else
{
	 echo true;
 
}

?>