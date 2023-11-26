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
            $this->conn->exec("SET time_zone = '+05:30';");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
    }

    public function getValue($value_name, $required = true, $default = null) {
        if (!empty($_REQUEST[$value_name])) {
            return ($_REQUEST[$value_name]);
        } 
        else {  
            if($required) {
                http_response_code(400);
    
                // tell the user no products found
                echo json_encode(
                    array("message" => "Required parameter missing.")
                );
                die();
            }
            else {
                return $default;
            }
        }
    }

    public function execute($query) {
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    public function check_user($user_key, $ip_address) {
        // select all query
        $query = "SELECT user_id from software WHERE user_key='$user_key'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();

        //$num = $stmt->rowCount();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            return $row['user_id'];
        }
        else {
            $query = "INSERT INTO register 
                        (user_key, ip_address) 
                    VALUES
                        ('$user_key', '$ip_address')
                    ";
        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
            return 0;
        }
    }

    public function device_update_piezo($device_number, $value, $unit, $temp) {
        $stmt = $this->conn->prepare("SELECT id FROM devices WHERE device_number='$device_number'");
    
        // execute query
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $device_id = $row['id'];
        }
        else {
            return null;
        }

        $query = "INSERT INTO piezo_history (device_id, `value`, unit, temp, update_date)
                    VALUES ($device_id, $value, '$unit', $temp, CURDATE())
                    ON DUPLICATE KEY UPDATE
                    `value` = $value, unit = '$unit', temp = $temp, update_time=NOW()
                 ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();

        if( $stmt->rowCount() > 0 )
            return true;
        else
            return false;

    }

}
