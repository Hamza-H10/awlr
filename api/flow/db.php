<?php

class Database {
 
    private $host = "localhost";
    private $db_name = "flowmeter_db";
    private $username = "flowmeter_user";
    private $password = "s5R,ucJ!)@}W";
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

    public function check_device_type($device_number) {
        // select all query
        $query = "SELECT device_type from devices WHERE device_number='$device_number'";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();

        //$num = $stmt->rowCount();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            return $row['device_type'];
        }
        else {
            return "none";
        }
    }

    public function add_device($device_number, $device_friendly_name, $device_type, $user_id) {
        // select all query
        $query = "INSERT INTO devices 
                    (device_number, user_id, device_friendly_name, device_type) 
                  VALUES
                    ('$device_number', $user_id, '$device_friendly_name', '$device_type')
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

    public function delete($device_number, $user_id) {
        // select all query
        $query = "DELETE FROM devices 
                   WHERE
                  device_number = '$device_number' AND user_id = $user_id
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
    
    public function device_list($user_id) {
        $query = "SELECT
                device_number, device_friendly_name, update_time, if(update_time > now() - interval 1 day, 'ON', 'OFF') As dev_stat, dev_x, dev_y
                FROM
                devices AS d LEFT JOIN history ON device_id=d.id AND update_date=(SELECT max(update_date) FROM history WHERE device_id=d.id) WHERE device_type='UFM' AND user_id = $user_id UNION
                SELECT
                device_number, device_friendly_name, update_time, if(update_time > now() - interval 1 day, 'ON', 'OFF') As dev_stat, dev_x, dev_y
                FROM
                devices AS d LEFT JOIN piezo_history ON device_id=d.id AND update_date=(SELECT max(update_date) FROM piezo_history WHERE device_id=d.id) WHERE device_type='PIEZOMETER' AND user_id = $user_id
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    public function device_list_ufm($user_id) {
        $query = "SELECT
                device_id, device_number, device_friendly_name, flow_rate, total_pos_flow, signal_strength, update_time
                FROM
                devices AS d LEFT JOIN history ON device_id=d.id AND update_date=(SELECT max(update_date) FROM history WHERE device_id=d.id) WHERE device_type='UFM' AND user_id = $user_id ORDER BY device_friendly_name
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    public function device_list_piezo($user_id) {
        $query = "SELECT
                device_number, device_friendly_name, `value`, unit, temp, update_time
                FROM
                devices AS d LEFT JOIN piezo_history ON device_id=d.id AND update_date=(SELECT max(update_date) FROM piezo_history WHERE device_id=d.id) WHERE device_type='PIEZOMETER' AND user_id = $user_id ORDER BY device_friendly_name
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    public function device_update_ufm($device_number, $flow_rate, $total_pos_flow, $signal_strength) {
        $stmt = $this->conn->prepare("SELECT id FROM devices WHERE device_number='$device_number'");
    
        // execute query
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $device_id = $row['id'];
        }
        else {
            return null;
        }

        $query = "INSERT INTO history (device_id, flow_rate, total_pos_flow, signal_strength, update_date)
                    VALUES ($device_id, $flow_rate, $total_pos_flow, $signal_strength, CURDATE())
                    ON DUPLICATE KEY UPDATE
                    flow_rate = $flow_rate, total_pos_flow = $total_pos_flow, signal_strength = $signal_strength, update_time=NOW()
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

    public function device_history_ufm($user_id, $device_number) {
        $query = "SELECT
                flow_rate, total_pos_flow, signal_strength, update_time, 'update_date'
                FROM
                devices INNER JOIN history ON device_id=devices.id 
                WHERE user_id = $user_id AND device_number='$device_number' 
                ORDER BY update_time DESC
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    public function device_history_piezo($user_id, $device_number) {
        $query = "SELECT
                `value`, unit, temp, update_time, 'update_date'
                FROM
                devices INNER JOIN piezo_history ON device_id=devices.id 
                WHERE user_id = $user_id AND device_number='$device_number' 
                ORDER BY update_time DESC
                ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

}
