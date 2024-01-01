<?php
require_once("../dbcon.php");
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$sql = "delete from devices where id=" . $id;
$details = array();
if (!$result = $conn->query($sql)) {
    echo $conn->error;
} else {
    header('Location: index.php');
}
