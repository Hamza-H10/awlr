<?php
session_start();



class db
{
	private $dbhost = 'localhost';
	private $dbuser = 'alwr_admin';
	private $dbpass = 'admin@123';
	private $dbname = 'site_alwr';

	private $conn;

	// connect function
	public function connect()
	{
		$con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		return $con;
	}
	// ---------------------
	// constructor with database connection
	public function __construct()
	{
		$this->conn = null;

		try {
			$this->conn = new PDO("mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname, $this->dbuser, $this->dbpass);
			$this->conn->exec("set names utf8");
			$this->conn->exec("SET @@session.time_zone = '+05:30';"); //this ensures that any date and time operations performed in the database will consider this time zone.
		} catch (PDOException $exception) {
			echo "Connection error: " . $exception->getMessage();
		}
	}

	// function for authenticate user_error
	public function authenticate($token)
	{
		$con = $this->connect();
		$sql = "SELECT id FROM authentication WHERE token = '$token' ";
		$query = mysqli_query($con, $sql);
		$auth = mysqli_fetch_assoc($query);
		//print_r($auth);
		$auth_id = $auth['id'];
		$_SESSION['auth_id'] = $auth_id;
		if (!empty($auth)) {
			return true;
		} else {
			return false;
		}
	}

	public function execute($query)
	{
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
	}
}
