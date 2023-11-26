<?php
session_start();

class db{
	private $dbhost = 'localhost';
	private $dbuser = 'alwr_admin';
	private $dbpass = 'admin@123';
	private $dbname = 'site_alwr';
	
	// connect function
	public function connect(){		
		$con = mysqli_connect($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);
		return $con;
	}
	
	// function for authenticate user_error
	public function authenticate($token){
		$con = $this->connect();
		$sql = "SELECT id FROM authentication WHERE token = '$token' ";
		$query = mysqli_query($con, $sql);
		$auth = mysqli_fetch_assoc($query);
		//print_r($auth);
		$auth_id = $auth['id'];
		$_SESSION['auth_id'] = $auth_id;
		if(!empty($auth)){
			return true;
		}else{
			return false;
		}
	}
}
?>
