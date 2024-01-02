<?php
error_reporting(0);

date_default_timezone_set('Asia/Kolkata');

//set url
include('url.php');
// include('C:\xampp\htdocs\awlr\api\inclino\url.php');


//$set_url='http://tdcpl.com/gargsingla.com/';

function url()
{
	global $default_url_set;
	$url = $default_url_set;
	return $url;
}

function active($page)
{
	$choose = basename($_SERVER['PHP_SELF']);

	if ($choose == $page) {
		$active = 'active';
	} else {
		$active = '';
	}

	return $active;
}

//set db config
$db_host = "localhost";
$db_name = "site_alwr";
$db_user = "alwr_admin";
// $db_user = "root";
$db_pass = "admin@123";
// $db_pass = "";

try {

	$db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
}
