<?php

    if(!isset($session_user_type)) {
        echo "You cannot directly access this page.";
        die();
    }

    $database = new Database();

    if($redirect == "device_list") {
        $page_limit = 10;
        $page_num =  getValue("pgno", false, 1);

        $stmt = $database->execute("SELECT COUNT(*) AS total_records FROM devices where user_id=".$session_user_id);
        $results_arr = array();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total_records = $row['total_records'];
            $total_pages = intval($total_records / $page_limit) + (($total_records % $page_limit) ? 1:0);
            if($page_num < 1)
                $page_num = 1;
            elseif($page_num > $total_pages)
                $page_num = $total_pages;

            $results_arr["cur_page"] = $page_num;
            $page_start = ($page_num - 1) * $page_limit;
            $results_arr["total_pages"] = $total_pages;
            $results_arr["page_start"] = $page_start;
            $results_arr["total_records"] = $total_records;
        }
        else {
            http_response_code(404);
            
            // tell the user no products found
            echo json_encode(
                array("message" => "No records found.", "records" => null)
            );
        }

        $stmt = $database->execute("SELECT id as row_id, device_number, device_short_name from devices where user_id = $session_user_id LIMIT $page_start, $page_limit");
        $num = $stmt->rowCount();
        
        if($num > 0){
        
            $results_arr["records"]=array();
            $results_arr["text_align"]=array('', 'right', 'left', 'center');
            //$curtime = time();
            
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //$last_update = getTimeText($row['date_time'], $curtime);
                $alert_item = array(
                    "row_id" => $row['row_id'],
                    "device_number"=>$row['device_number'],
                    "device_name" => html_entity_decode($row['device_short_name']),
                    "action" => "<a href='$app_root/?page=devicedata&device_id=".$row['row_id']."&sensor_no=0'><i class='share icon'></i></a>",
                );

                array_push($results_arr["records"], $alert_item);
            }

            $results_arr["page_limit"] = $num;
            // set response code - 200 OK
            http_response_code(200);
            
            // show products data in json format
            echo json_encode($results_arr);
        }
        else {
            http_response_code(200);
            
            // show products data in json format
            echo json_encode(
                array("message" => "No records found.", "records" => null)
            );

        }
    }
    elseif($redirect == "device_data") {
        $page_limit = 10;
        $page_num =  getValue("pgno", false, 1);
        $device_id = getValue("device_id");
        $sensor_no = getValue("sensor_no");
        $search_text = "";
        if($sensor_no > 0)
           $search_text = " and value2='Ue-CH$sensor_no'";

        $stmt = $database->execute("SELECT COUNT(*) AS total_records FROM device_data where device_id=$device_id $search_text");
        $results_arr = array();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total_records = $row['total_records'];
            $total_pages = intval($total_records / $page_limit) + (($total_records % $page_limit) ? 1:0);
            if($page_num < 1)
                $page_num = 1;
            elseif($page_num > $total_pages)
                $page_num = $total_pages;

            $results_arr["cur_page"] = $page_num;
            $page_start = ($page_num - 1) * $page_limit;
            $results_arr["total_pages"] = $total_pages;
            $results_arr["page_start"] = $page_start;
            $results_arr["total_records"] = $total_records;
        }
        else {
            http_response_code(404);
            
            // tell the user no products found
            echo json_encode(
                array("message" => "No records found.", "records" => null)
            );
        }

        $stmt = $database->execute("SELECT id as row_id, date_time, value1, value2 from device_data where device_id = $device_id $search_text ORDER BY date_time DESC LIMIT $page_start, $page_limit");
        $num = $stmt->rowCount();
        
        if($num > 0){
        
            $results_arr["records"]=array();
            if($sensor_no > 0)
                $results_arr["text_align"]=array('', 'left', 'right', 'center');
            else
                $results_arr["text_align"]=array('', 'left', 'center', 'right', 'center');
            //$curtime = time();
            
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $time_val = strtotime($row['date_time']);
            
                if($sensor_no > 0)
                    $alert_item = array(
                        "row_id" => $row['row_id'],
                        "date_time"=> date("d/m/Y h:i:sa", $time_val),
                        "value" => $row['value1'],
                        "unit" => "&#181;e",
                    );
                else {
                    switch($row['value2']) {
                        case "Ue-CH1":
                            $sensor_value = "15-03-22-06 (Sensor 1)";
                            break;
                        case "Ue-CH2":
                            $sensor_value = "15-03-28-84 (Sensor 2)";
                            break;
                        case "Ue-CH3":
                            $sensor_value = "00-00-4E-00 (Sensor 3)";
                            break;
                        case "Ue-CH4":
                            $sensor_value = "15-03-32-02 (Sensor 4)";
                            break;
                        default:
                            $sensor_value = "";
                    }
                    $alert_item = array(
                        "row_id" => $row['row_id'],
                        "date_time"=> date("d/m/Y h:i:sa", $time_val),
                        "sensor" => $sensor_value,
                        "value" => $row['value1'],
                        "unit" => "&#181;&#949; (microstrain)",
                    );
                }
                array_push($results_arr["records"], $alert_item);
            }

            $results_arr["page_limit"] = $num;
            // set response code - 200 OK
            http_response_code(200);
            
            // show products data in json format
            echo json_encode($results_arr);
        }
        else {
            http_response_code(200);
            
            // show products data in json format
            echo json_encode(
                array("message" => "No records found.", "records" => null)
            );

        }
    }
    else {
        // set response code - 404 Not found
        http_response_code(404);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "Invalid Link Specified.", "records" => null)
        );
    }

?>