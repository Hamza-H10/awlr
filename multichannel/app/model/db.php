<?php

class Database {
 
    private $host = "localhost";
    private $db_name = "db_invwire";
    private $username = "alwr_admin";
    private $password = "admin@123";
    // database connection and table name
    private $conn;
 
    // constructor with database connection
    public function __construct() {
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->exec("SET @@session.time_zone = '+05:30';");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

    }

    public function execute($query) {
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}