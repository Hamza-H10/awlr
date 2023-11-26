<?php

$salt1 = "qm&h*bZ";
$salt2 = "pg!A@M";
$app_root = "http://awlr.in/dgc";

class Database {
 
    private $host = "localhost";
    private $db_name = "site_alwr";
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
            // $this->conn->exec("SET @@session.time_zone = '+05:30';");
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
    
    public function lastinsertid() {
        return $this->conn->lastInsertId();
    }
}

function hashPassword($password) {
    global $salt1, $salt2;
    return hash('SHA1', "$salt1$password$salt2");
}

function getValue($value_name, $required = true, $default = null) {
    if (isset($_REQUEST[$value_name])) {
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
