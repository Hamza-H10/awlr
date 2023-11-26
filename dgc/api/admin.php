<?php
    function getDateString($num) {
        
        if($num == 0) return("N/A");
        
        $dtPart = 0;
        $timPart = 0.0;
        $dtmValues[1] = 31; $dtmValues[2] = 28; $dtmValues[3] = 31; $dtmValues[4] = 30; $dtmValues[5] = 31; $dtmValues[6] = 30;
        $dtmValues[7] = 31; $dtmValues[8] = 31; $dtmValues[9] = 30; $dtmValues[10] = 31; $dtmValues[11] = 30; $dtmValues[12] = 31;
        
        $out = explode(".", $num);
        if (count($out) == 2)
            $timPart = (double) ("0." . $out[1]);
        else
            $timPart = 0.0;
    
        $dtPart = (int)($out[0]);
    
        // Extract Date
        $year = intval(($dtPart - 1) / 365.25);
        $dtPart = $dtPart - ($year * 365.25);
        if ($year % 4 == 0) $dtmValues[2] = $dtmValues[2] + 1;
        
        $total = 0;
        for ($n = 1; $n <= 12; $n++) {
            if ($dtPart < ($total + $dtmValues[$n])) break;
            $total = $total + $dtmValues[$n];
        }
        $year = $year + 1900;
        $dayofmonth = $dtPart - $total;
        $monthofyear = $n;
        
        // Extract time
        $hours = intval($timPart * 24);
        $timPart = $timPart - ($hours / 24);
        $minutes = intval($timPart * 1440);
        $timPart = $timPart - ($minutes / 1440);
        $seconds = intval($timPart * 86400);
    
        // 17 * 1/24 + 25 * 1/1440 +
    
        $retval = sprintf ("%02d-%02d-%d %02d:%02d:%02d",  $dayofmonth, $monthofyear, $year, $hours, $minutes, $seconds);
        return($retval);
    }

    if(!isset($session_user_type)) {
        echo "You cannot directly access this page.";
        die();  
    }

    $database = new Database();
    

    switch($redirect) {
        case "user_fetch":
            $edit_id = getValue("row_id");
            $stmt = $database->execute("SELECT id as row_id, user_name, user_email, user_type FROM users WHERE id=".$edit_id);

            http_response_code(200);
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results_arr["status"] = 'success';

                $results_arr["user_name"] = $row['user_name'];
                $results_arr["user_email"] = $row['user_email'];
                $results_arr["user_type"] = $row['user_type'];
                
                // show products data in json format
                echo json_encode($results_arr);
            }
            else {
                $results_arr["status"] = 'error';
                $results_arr["message"] = 'Unable to fetch record.';

                echo json_encode($results_arr);
            }
            break;
        case "user_add":
        case "user_edit":
            $user_name = getValue("user_name");
            $user_email = getValue("user_email");
            $user_type = getValue("user_type");
            $license_type = getValue("license_type");
            $license_period = getValue("license_period");
            $extra_condition = "";
            if($redirect === 'user_edit') {
                $edit_id = getValue("row_id");
                $extra_condition = " AND id <> $edit_id";
            }
            else {
                $user_password = hashPassword(getValue("user_password"));
            }
            $stmt = $database->execute("SELECT id FROM users WHERE user_email='$user_email' $extra_condition");
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                http_response_code(200);
                
                // tell the user email found
                echo json_encode(
                    array("status" => "error", "message" => "Email address already exists.", "records" => "")
                );
                break;
            }
            else {
                if($redirect === 'user_edit') {
                    //$stmt = $database->execute("UPDATE users SET user_name='$user_name', user_email='$user_email', user_type=$user_type WHERE id=".$edit_id);
                }
                else {
                    $stmt = $database->execute("INSERT INTO users (user_name, user_email, user_password, user_type) VALUES ('$user_name', '$user_email', '$user_password', $user_type)");
                    $last_id = $database->lastinsertid();
                    $stmt = $database->execute("INSERT INTO licenses (user_id, license_type, license_period) VALUES ($last_id, $license_type, $license_period)");
                }
                $num = $stmt->rowCount();
                if($num) {
                    http_response_code(200);

                    echo json_encode(
                        array("status" => "success", "message" => ".", "records" => "")
                    );
                }
                else {
                    http_response_code(400);
                    echo json_encode(
                        array("message" => "Record could not be modified.", "records" => "")
                    );
                }
            }
            break;
        case "user_delete":
            $del_id =  getValue("del_id");
            $stmt = $database->execute("UPDATE licenses SET mac_id='', user_key='' WHERE id IN ($del_id)");
            $num = $stmt->rowCount();
            
            if($num){
            
            }
            else {
                http_response_code(400);
                
                // tell the user no products found
                echo json_encode(
                    array("message" => "Records could not be deleted.", "records" => null)
                );
                break;
            }
            //break;
        case "user_list":
            $page_limit = 10;
            $page_num =  getValue("pgno", false, 1);
            $search_text = getValue("search", false, '');
            $option = getValue("option", false, '');

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

            $stmt = $database->execute("SELECT licenses.id as row_id, user_name, user_email, user_type, license_type, license_period, if(mac_id='','Not Installed','Installed') As status, time_end FROM users, licenses $search_text LIMIT $page_start, $page_limit");
            $num = $stmt->rowCount();
            
            if($num > 0){
            
                $results_arr["records"]=array();
                $results_arr["text_align"]=array('', 'left', 'left', 'center', 'left', 'center', 'right', 'left');
                //$curtime = time();
                
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    //$last_update = getTimeText($row['date_time'], $curtime);
            
                    $user_type = ($row['user_type'] == 1) ? "Admin" : "User";
                    switch($row['license_type']) {
                        case 1: $license_type = "NTSC-NPF";break;
                        case 2: $license_type = "NTSC-WPF";break;
                        case 3: $license_type = "WTSC-NPF";break;
                        case 4: $license_type = "WTSC-WPF";break;
                        case 5: $license_type = "LE-NTSC-NPF";break;
                        case 6: $license_type = "LE-NTSC-WPF";break;
                        case 7: $license_type = "LE-WTSC-NPF";break;
                        case 8: $license_type = "LE-WTSC-WPF";break;
                    }
                    $alert_item=array(
                        "row_id" => $row['row_id'],
                        "user_name" => html_entity_decode($row['user_name']),
                        //"date_time" => date("d/m/Y h:i:sa", strtotime($row['date_time'])),
                        "user_email" => $row['user_email'],
                        "user_type" => $user_type,
                        "license_type" => $license_type,
                        "license_period" => $row['license_period'],
                        "status" => $row['status'],
                        "time_end" => getDateString($row['time_end'])
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
            
                // set response code - 404 Not found
                http_response_code(404);
                
                // tell the user no products found
                echo json_encode(
                    array("message" => "No users found.", "records" => null)
                );
            }
        
            break;
        case "repeat_list":
            $page_limit = 10;
            $page_num =  getValue("pgno", false, 1);

            $stmt = $database->execute("SELECT COUNT(*) as total_records from licenses a1, users where users.id = a1.user_id and mac_id!='' and 1 < (SELECT count(*) FROM licenses where mac_id=a1.mac_id)");
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

            $stmt = $database->execute("SELECT a1.id as row_id, user_name, user_email, a1.mac_id as mac_id, a1.time_start as time_start from licenses a1, users where users.id = a1.user_id and mac_id!='' and 1 < (SELECT count(*) FROM licenses where mac_id=a1.mac_id) ORDER BY a1.mac_id, user_name  LIMIT $page_start, $page_limit");
            $num = $stmt->rowCount();

            if($num > 0){
            
                $results_arr["records"]=array();
                $results_arr["text_align"]=array('', 'left', 'left', 'center', 'center');
                //$curtime = time();
                
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    //$last_update = getTimeText($row['date_time'], $curtime);
            
                    $alert_item=array(
                        "row_id" => $row['row_id'],
                        "name" => $row['user_name'],
                        "email" => $row['user_email'],
                        "mac_ID" => $row['mac_id'],
                        "time_start" => getDateString($row['time_start']),
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
            
                // set response code - 404 Not found
                http_response_code(404);
                
                // tell the user no products found
                echo json_encode(
                    array("message" => "No users found.", "records" => null)
                );
            }
        
            break;
        case "potential_list":
            $page_limit = 10;
            $page_num =  getValue("pgno", false, 1);

            $stmt = $database->execute("SELECT COUNT(*) as total_records from potential");
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

            $stmt = $database->execute("SELECT id as row_id, user_email, ip_address, mac_id, time_record from potential ORDER BY time_record DESC LIMIT $page_start, $page_limit");
            $num = $stmt->rowCount();

            if($num > 0){
            
                $results_arr["records"]=array();
                $results_arr["text_align"]=array('', 'left', 'center', 'center', 'center');
                //$curtime = time();
                
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    //$last_update = getTimeText($row['date_time'], $curtime);
            
                    $alert_item=array(
                        "row_id" => $row['row_id'],
                        "email" => $row['user_email'],
                        "ip_address" => "<a href='https://www.ip2location.com/".$row['ip_address']."' target='_blank'><i class='copy icon'></i></a>",
                        "mac_ID" => $row['mac_id'],
                        "time_record" => getDateString($row['time_record']),
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
            
                // set response code - 404 Not found
                http_response_code(404);
                
                // tell the user no products found
                echo json_encode(
                    array("message" => "No users found.", "records" => null)
                );
            }
        
            break;

        default:
            // set response code - 404 Not found
            http_response_code(404);
            
            // tell the user no products found
            echo json_encode(
                array("message" => "Invalid Link Specified.", "records" => null)
            );
    }

?>