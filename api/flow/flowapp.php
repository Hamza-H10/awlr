<?php
// required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Asia/Kolkata');
 
// include database and object files
require_once 'db.php';
 
// instantiate database and product object
$database = new Database();

$user_id =  $database->getValue("user_id"); 
$action = $database->getValue("action"); 

if($action != "update") {
    $user_id = $database->check_user($user_id, $_SERVER['REMOTE_ADDR']);
    if($user_id == 0) {
        http_response_code(400);
    
        echo json_encode(
            array("message" => "Invalid User Identification.")
        );
        die();
    }
}

if($action == "add") {
    $friendly_name = $database->getValue("friendly_name");
    $device_number = $database->getValue("device_number"); 
    $device_type = $database->getValue("device_type"); 
    if( $database->register($device_number, $friendly_name, $device_type, $user_id)) {
        // set response code - 200 OK
        http_response_code(200);
        
        // tell the user successful
        echo json_encode(
            array("message" => "Device added successfully.")
        );
    }
    else {
        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no device could be added
        echo json_encode(
            array("message" => "Device could not be added.")
        );
        die();
    }
}
else if($action == "delete") {
    $device_number = $database->getValue("device_number");
    if( $database->delete($device_number, $user_id)) {
        // set response code - 200 OK
        http_response_code(200);
        
        // tell the user successful
        echo json_encode(
            array("message" => "device deleted successfully.")
        );
    }
    else {
        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no device could be added
        echo json_encode(
            array("message" => "device could not be deleted.")
        );
        die();
    }
}
else if($action == "update") {
    $device_number = $database->getValue("device_number");
    $error = "Device could not be updated.";
    $result = 1;
    
    switch($database->check_device_type($device_number)) {
        case "UFM": case "EM":
            $flow_rate = $database->getValue("flow_rate", false, 0);
            $total_pos_flow = $database->getValue("total_pos_flow", false, 0); 
            $signal_strength = $database->getValue("signal_strength", false, 0);

            $database->device_update_ufm($device_number, $flow_rate, $total_pos_flow, $signal_strength);
            break;
        case "PIEZOMETER":
            $value = $database->getValue("value", false, 0);
            $unit = $database->getValue("unit"); 
            $temp = $database->getValue("temp", false, 0);

            $database->device_update_piezo($device_number, $value, $unit, $temp);
            break;
        case "none":
            $result = 0;
            $error = "Device not found!";
            break;

    }
    if($result) {
        // set response code - 200 OK
        http_response_code(200);
        
        // tell the user successful
        echo json_encode(
            array("message" => "Device updated successfully.")
        );
    }
    else {
        // set response code - 404 Not found
        http_response_code(404);
        file_put_contents("log.txt", date("Y-m-d H:i:s")." => DEVICENUM=[".$device_number."]\r\n", FILE_APPEND);

        // tell the user no device could be added
        echo json_encode(
            array("message" => $error)
        );
        die();
    }
}
else if($action == "historic") {
    $device_number = $database->getValue("device_number");
    $stmt = $database->execute("SELECT id FROM devices WHERE user_id=$user_id AND device_number='$device_number'");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $device_id = $row["id"];
    else {
        echo json_encode(
            array("message" => "Device not found.")
        );
        die();
    }

    $device_arr = getdmy($device_id);
    // set response code - 200 OK
    http_response_code(200);
    
    // show products data in json format
    echo json_encode($device_arr);

}
else if($action == "monthly_graph") {
    $device_number = $database->getValue("device_number");
    $month = $database->getValue("month");
    $year = $database->getValue("year");
    $stmt = $database->execute("SELECT id FROM devices WHERE user_id=$user_id AND device_number='$device_number'");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $device_id = $row["id"];
    else {
        echo json_encode(
            array("message" => "Device not found.")
        );
        die();
    }
    $device_arr=array();
    $device_arr["records"]=array();
    
    $stmt = $database->execute("SELECT update_date, total_pos_flow as cur_flow, (SELECT total_pos_flow FROM history hist2 WHERE hist2.update_date = hist1.update_date - interval 1 day AND hist2.device_id=$device_id) As prev_flow FROM `history` hist1 WHERE hist1.device_id=$device_id AND month(hist1.update_date)=$month AND YEAR(hist1.update_date)=$year");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $device_item = array(
            "update_date" => date("d", strtotime($row['update_date'])),
            "cur_flow" => $row['cur_flow'],
            "prev_flow" => (is_null($row['prev_flow']) ? 0 : $row['prev_flow'])
        );
    
        array_push($device_arr["records"], $device_item);
    }    
    // set response code - 200 OK
    http_response_code(200);
    
    // show products data in json format
    echo json_encode($device_arr);
}
else if ($action == "list_month_year_ufm") {
    $device_number = $database->getValue("device_number");
    $stmt = $database->execute("SELECT id FROM devices WHERE user_id=$user_id AND device_number='$device_number'");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $device_id = $row["id"];
    else {
        echo json_encode(
            array("message" => "Device not found.")
        );
        die();
    }
    $device_arr=array();
    $device_arr["records"]=array();
    
    $stmt = $database->execute("SELECT distinct month(update_date) as dt_month, year(update_date) as dt_year FROM history WHERE device_id=$device_id");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $device_item = array(
            "date_month" => $row['dt_month'],
            "date_year" => $row['dt_year']
        );
        array_push($device_arr["records"], $device_item);
    }    
    // set response code - 200 OK
    http_response_code(200);
    
    // show products data in json format
    echo json_encode($device_arr);
    
}
else if ($action == "list_ufm_devices_only") {
    $stmt = $database->execute("SELECT device_number, device_friendly_name FROM devices WHERE device_type='UFM' ORDER BY device_friendly_name");
    $device_arr=array();
    $device_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $device_item = array(
            "device_number" => $row['device_number'],
            "device_name" => html_entity_decode($row['device_friendly_name'])
        );
    
        array_push($device_arr["records"], $device_item);
    }
    
    // set response code - 200 OK
    http_response_code(200);
    
    // show products data in json format
    echo json_encode($device_arr);
}
else if($action == "list_all") {
    $stmt = $database->device_list($user_id);
    $num = $stmt->rowCount();
    if($num > 0){

        // device array
        $device_arr=array();
        $device_arr["records"]=array();

        // retrieve our table contents
        // device_friendly_name, flow_rate, total_pos_flow, signal_strength, last_update
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $time_val = strtotime($row['update_time']);
            $device_item = array(
                "device_number" => $row['device_number'],
                "device_name" => html_entity_decode($row['device_friendly_name']),
                "last_update" => date("d/m/Y h:i:sa", $time_val),
                "device_status" => $row['dev_stat'],
                "dev_x" => $row['dev_x'],
                "dev_y" => $row['dev_y']
            );
        
            array_push($device_arr["records"], $device_item);
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($device_arr);
    }        
    else {

        // set response code - 404 Not found
        http_response_code(200);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "No record found.", "records" => null)
        );
    }
}
else if($action == "list_ufm") {
    $stmt = $database->device_list_ufm($user_id);
    $num = $stmt->rowCount();

    if($num > 0){

        // device array
        $device_arr=array();
        $device_arr["records"]=array();
        $curtime = time();
        
        // retrieve our table contents
        // device_friendly_name, flow_rate, total_pos_flow, signal_strength, last_update
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $time_val = strtotime($row['update_time']);
            $dmy_details = getdmy($row['device_id']);
            $device_status = "ONLINE";
            if($curtime - $time_val > 86400)
                $device_status = "OFFLINE";
            $device_item = array(
                "device_number" => $row['device_number'],
                "device_name" => html_entity_decode($row['device_friendly_name']),
                "flow_rate" => $row['flow_rate'],
                "total_positive_flow" => $row['total_pos_flow'],
                "signal_strength" => $row['signal_strength'],
                "last_update" => date("d/m/Y h:i:sa", $time_val),
                "device_status" => $device_status,
                "daily" => $dmy_details['daily'],
                "monthly" => $dmy_details['monthly'],
                "yearly" => $dmy_details['yearly']
            );
        
            array_push($device_arr["records"], $device_item);
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($device_arr);
    }        
    else {

        // set response code - 404 Not found
        http_response_code(200);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "No record found.", "records" => null)
        );
    }
}
else if($action == "history_ufm") {
    $device_number = $database->getValue("device_number");

    $stmt = $database->device_history_ufm($user_id, $device_number);
    $num = $stmt->rowCount();

    if($num > 0){

        // device array
        $hist_arr=array();
        $hist_arr["records"]=array();
        
        // retrieve our table contents
        // device_friendly_name, flow_rate, total_pos_flow, signal_strength, last_update
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $device_item = array(
                "flow_rate" => $row['flow_rate'],
                "total_positive_flow" => $row['total_pos_flow'],
                "signal_strength" => $row['signal_strength'],
                "update_time" => date("d/m/Y h:i:sa", strtotime($row['update_time']))
            );
        
            array_push($hist_arr["records"], $device_item);
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($hist_arr);
    }        
    else {

        // set response code - 404 Not found
        http_response_code(200);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "No device history found.", "records" => null)
        );
    }

}
else if($action == "list_piezo") {
    $stmt = $database->device_list_piezo($user_id);
    $num = $stmt->rowCount();

    if($num > 0){

        // device array
        $device_arr=array();
        $device_arr["records"]=array();
        $curtime = time();
        
        // retrieve our table contents
        // device_friendly_name, flow_rate, total_pos_flow, signal_strength, last_update
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $time_val = strtotime($row['update_time']);
            $device_status = "ONLINE";
            if($curtime - $time_val > 86400)
                $device_status = "OFFLINE";
            $device_item = array(
                "device_number" => $row['device_number'],
                "device_name" => html_entity_decode($row['device_friendly_name']),
                "value" => $row['value'],
                "unit" => $row['unit'],
                "temp" => $row['temp'],
                "last_update" => date("d/m/Y h:i:sa", $time_val),
                "device_status" => $device_status
            );
        
            array_push($device_arr["records"], $device_item);
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($device_arr);
    }        
    else {

        // set response code - 404 Not found
        http_response_code(200);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "No device added yet.", "records" => null)
        );
    }
}
else if($action == "history_piezo") {
    $device_number = $database->getValue("device_number");

    $stmt = $database->device_history_piezo($user_id, $device_number);
    $num = $stmt->rowCount();

    if($num > 0){

        // device array
        $hist_arr=array();
        $hist_arr["records"]=array();
        
        // retrieve our table contents
        // device_friendly_name, flow_rate, total_pos_flow, signal_strength, last_update
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $device_item = array(
                "value" => $row['value'],
                "unit" => $row['unit'],
                "temp" => $row['temp'],
                "update_time" => date("d/m/Y h:i:sa", strtotime($row['update_time']))
            );
        
            array_push($hist_arr["records"], $device_item);
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode($hist_arr);
    }        
    else {

        // set response code - 404 Not found
        http_response_code(200);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "No device history found.", "records" => null)
        );
    }

}else  {
    http_response_code(400);
    
    echo json_encode(
        array("message" => "Wrong operation '$action'.")
    );
    die();
}

function getdmy($device_id)
{
    global $database;
    $min_day = $max_day = $min_month = $max_month = $min_year = $max_year = -1;

    $stmt = $database->execute("SELECT total_pos_flow FROM history WHERE device_id = $device_id AND update_date = CURRENT_DATE() - interval 2 day");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $min_day = $row["total_pos_flow"];
    $stmt = $database->execute("SELECT total_pos_flow FROM history WHERE device_id = $device_id AND update_date = CURRENT_DATE() - interval 1 day");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $max_day = $row["total_pos_flow"];
        
    $stmt = $database->execute("SELECT total_pos_flow FROM history WHERE device_id = $device_id AND update_date = (SELECT min(update_date) FROM history WHERE device_id = $device_id AND month(update_date) = MONTH(CURRENT_DATE())-1 AND Year(update_date) = year(CURRENT_DATE()) )");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $min_month = $row["total_pos_flow"];
    $stmt = $database->execute("SELECT total_pos_flow FROM history WHERE device_id = $device_id AND update_date = (SELECT max(update_date) FROM history WHERE device_id = $device_id AND month(update_date) = MONTH(CURRENT_DATE())-1 AND Year(update_date) = year(CURRENT_DATE()) )");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $max_month = $row["total_pos_flow"];

    $stmt = $database->execute("SELECT total_pos_flow FROM history WHERE device_id = $device_id AND update_date = (SELECT min(update_date) FROM history WHERE device_id = $device_id AND Year(update_date) = Year(CURRENT_DATE())-1)");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $min_year = $row["total_pos_flow"];
    $stmt = $database->execute("SELECT total_pos_flow FROM history WHERE device_id = $device_id AND update_date = (SELECT max(update_date) FROM history WHERE device_id = $device_id AND Year(update_date) = Year(CURRENT_DATE())-1)");
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $max_year = $row["total_pos_flow"];
    
    $device_arr=array();
    $device_arr["daily"] = 0;
    $device_arr["monthly"] = 0;
    $device_arr["yearly"] = 0;
    if($min_day >= 0 AND $max_day >= 0)
        $device_arr["daily"] = $max_day - $min_day;
    if($min_month >= 0 AND $max_month >= 0)
        $device_arr["monthly"] = $max_month - $min_month;
    if($min_year >= 0 AND $max_year >= 0)
        $device_arr["yearly"] = $max_year - $min_year;

    return($device_arr);
}
