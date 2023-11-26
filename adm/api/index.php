<?php // Check if form was submitted:
// required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Asia/Kolkata');
 
// include database and object files
require_once '../model/db.php';
require_once '../model/utils.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
    $user_id = 0;
    $location_id = 0;
    // instantiate database and product object
    $database = new Database();

    $action = getValue("action");

    if($action == "new") {
        $r_phone = getValue("phone");
        $stmt = $database->execute("SELECT id FROM users WHERE phone='$r_phone'");
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $user_id = $row["id"];
    }

    if($action == "new" || $action == "checkstart") {
        $r_location = getValue("location");
        $stmt = $database->execute("SELECT id FROM locations WHERE qrcode='$r_location'");
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $location_id = $row["id"];
    }

    if($action == "new") {
        $r_duration = getValue("duration");
        if($user_id == 0 || $location_id == 0) {
    
            $result_arr["status"] = "error";
            $result_arr["message"] = "Your request could not be initiated. Phone or email error has occured.";
            // set response code - 200 OK
            http_response_code(200);
        }
        else {
            $stmt = $database->execute("INSERT into requests (user_id, loc_id, duration) VALUES ($user_id, $location_id, $r_duration)");
            if($stmt->rowCount() > 0) {
                $stmt = $database->execute("SELECT LAST_INSERT_ID() As ID");
                
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result_arr["status"] = "success";
                    $result_arr["location"] = $location_id;
                    $result_arr["requestid"] = $row["ID"];
                    // set response code - 200 OK
                    http_response_code(200);
                }
            }
            else {
                $result_arr["status"] = "error";
                $result_arr["message"] = "Your request could not be initiated. An error has occured.";
                // set response code - 200 OK
                http_response_code(200);
      
            } 
        }
        echo json_encode($result_arr);
    }
    else if($action == "checkstart") {
        $stmt = $database->execute("SELECT id, duration FROM requests WHERE loc_id=$location_id and start_time=0");
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row_id = $row["id"];
            $r_duration = $row["duration"];
            $database->execute("UPDATE requests SET start_time=now() WHERE id=".$row_id);
            $database->execute("UPDATE locations SET status=1 WHERE id=".$location_id);
            echo $row_id.",".$r_duration;
        }
        else
            echo "0";
      
    }
    else if($action == "end") {
        $request_id = getValue("requestid");
        $watthour = getValue("energy");
        $stmt = $database->execute("SELECT loc_id FROM requests WHERE id=$request_id");
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $location_id = $row["loc_id"];
            $database->execute("UPDATE requests SET watthour=$watthour, end_time=now() WHERE id=".$request_id);
            $database->execute("UPDATE locations SET status=0 WHERE id=".$location_id);
            echo "1";
        }
        
        else {
            echo "0";
        }
        
    }
    else if($action == "checkend") {
        $request_id = getValue("requestid");
        $stmt = $database->execute("SELECT IF(end_time>start_time, 0, 1) AS status, watthour FROM requests WHERE id=$request_id");
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result_arr["status"] = $row["status"];
            $result_arr["duration"] = $row["watthour"];
            // set response code - 200 OK
            http_response_code(200);
        }    
        echo json_encode($result_arr);
    }
} 
?>