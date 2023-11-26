<?php

    if(!isset($session_user_type)) {
        echo "You cannot directly access this page.";
        die();
    }

    $database = new Database();

    if($redirect == "vw_list" || $redirect == "incl_list" || $redirect == "ldcell_list") {
        if($redirect == "incl_list") {
            $channel_id = getValue("channel");
            $slave_id = getValue("slave_no");
            $date_filter = getValue("date_filter", false, '');
            $table_name = "inplace_dd";
        }
        else { 
            $channel_id = getValue("channel_no");
            $slave_id = getValue("slave_no");
            $table_name = "vwire_dd";
        }
        $page_limit = 30;
        $page_start = 0;
        $page_num = getValue("pgno", false, 1);

        if($page_num == 0) {
            $option = "all";
        }
        else {
            $option = "page wise";
        }
    
        //$search_text = getValue("search", false, '');

        if($redirect == "incl_list") {
            if($date_filter != '') {
                $tmp_arr = explode(",", $date_filter);
                $n = 0;
                foreach($tmp_arr as $val) {
                    $tmp_arr[$n] = date("Y-m-d", strtotime($val) );
                    $n++;
                }
                $date_filter = "'" . implode ( "', '", $tmp_arr ) . "'";
                $search_text = " WHERE channel_no=7 AND slave_no=$slave_id AND date(record_time) IN ($date_filter)";
                $date_filter = " WHERE ina.channel_no=7 AND ina.slave_no=$slave_id AND date(ina.record_time) IN ($date_filter)";
            }
            else {
                $search_text = " WHERE channel_no=7 AND slave_no=$slave_id ";
                $date_filter = " WHERE ina.channel_no=7 AND ina.slave_no=$slave_id ";
            }
        }
        elseif($redirect == "vw_list")
            $search_text = " WHERE slave_no=$slave_id AND channel_no=$channel_id ";
        else {
            $channel2 = $channel_id + 1;
            $channel3 = $channel_id + 2;
            $search_text = " WHERE slave_no=$slave_id AND (channel_no=$channel_id OR channel_no=$channel2 OR channel_no=$channel3)";
        }

        $stmt = $database->execute("SELECT COUNT(*) AS total_records FROM $table_name $search_text");
        $results_arr = array();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total_records = $row['total_records'];
            //if($redirect == "ldcell_list")
            //    $total_records = intval($total_records/3);
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

        if($redirect == "incl_list") {

            $query = <<<EOD
            SELECT distinct ina.slave_no as slave_no, date(ina.record_time) as record_time,
            ina.{$channel_id}_data as {$channel_id}7, inb.{$channel_id}_data as {$channel_id}6,
            inc.{$channel_id}_data as {$channel_id}5, ind.{$channel_id}_data as {$channel_id}4, 
            ine.{$channel_id}_data as {$channel_id}3, inf.{$channel_id}_data as {$channel_id}2, 
            ing.{$channel_id}_data as {$channel_id}1
            FROM `inplace_dd` ina 
            left join `inplace_dd` inb on ina.slave_no = inb.slave_no AND date(ina.record_time)=date(inb.record_time)
                and inb.channel_no=6 
            left join `inplace_dd` inc on ina.slave_no = inc.slave_no AND date(ina.record_time)=date(inc.record_time) 
                and inc.channel_no=5 
            left join `inplace_dd` ind on ina.slave_no = ind.slave_no AND date(ina.record_time)=date(ind.record_time) 
                and ind.channel_no=4
            left join `inplace_dd` ine on ina.slave_no = ine.slave_no AND date(ina.record_time)=date(ine.record_time) 
                and ine.channel_no=3 
            left join `inplace_dd` inf on ina.slave_no = inf.slave_no AND date(ina.record_time)=date(inf.record_time) 
                and inf.channel_no=2 
            left join `inplace_dd` ing on ina.slave_no = ing.slave_no AND date(ina.record_time)=date(ing.record_time) 
                and ing.channel_no=1
            $date_filter ORDER BY ina.record_time DESC 
EOD;
//file_put_contents('logs.txt', $query.PHP_EOL , FILE_APPEND | LOCK_EX);
            /******************* SUBTRACTION QUERY *********************/
            $minQuery2 = <<<EOD
            SELECT distinct
            ina.{$channel_id}_data as {$channel_id}7, inb.{$channel_id}_data as {$channel_id}6,
            inc.{$channel_id}_data as {$channel_id}5, ind.{$channel_id}_data as {$channel_id}4, 
            ine.{$channel_id}_data as {$channel_id}3, inf.{$channel_id}_data as {$channel_id}2, 
            ing.{$channel_id}_data as {$channel_id}1
            FROM `inplace_dd` ina 
            left join `inplace_dd` inb on ina.slave_no = inb.slave_no AND date(ina.record_time)=date(inb.record_time)
                and inb.channel_no=6 
            left join `inplace_dd` inc on ina.slave_no = inc.slave_no AND date(ina.record_time)=date(inc.record_time) 
                and inc.channel_no=5 
            left join `inplace_dd` ind on ina.slave_no = ind.slave_no AND date(ina.record_time)=date(ind.record_time) 
                and ind.channel_no=4
            left join `inplace_dd` ine on ina.slave_no = ine.slave_no AND date(ina.record_time)=date(ine.record_time) 
                and ine.channel_no=3 
            left join `inplace_dd` inf on ina.slave_no = inf.slave_no AND date(ina.record_time)=date(inf.record_time) 
                and inf.channel_no=2 
            left join `inplace_dd` ing on ina.slave_no = ing.slave_no AND date(ina.record_time)=date(ing.record_time) 
                and ing.channel_no=1
            WHERE ina.channel_no=7 AND ina.slave_no=$slave_id AND date(ina.record_time)='2021-02-23' 
EOD;
        }
        elseif($redirect == "vw_list") 
            $query = "SELECT id as row_id, slave_no, channel_no, `data`, record_time FROM vwire_dd $search_text ORDER BY record_time DESC ";
        else 
            $query = "SELECT slave_no, avg(`data`) as avg_data, date(record_time) as record_time FROM vwire_dd $search_text GROUP BY record_time, slave_no ORDER BY record_time DESC ";
        
        if($option != "all") {
            $query .= " LIMIT $page_start, $page_limit ";
        }
        
        $stmt = $database->execute($query);
        $num = $stmt->rowCount();
//file_put_contents('logs.txt', "NUM=".$num.PHP_EOL , FILE_APPEND | LOCK_EX);

        if($num > 0) {
        
            $results_arr["records"]=array();
            if($redirect == "incl_list") {
                $stmt2 = $database->execute($minQuery2); // For initial query
                $num2 = $stmt2->rowCount();
                $rowMin = $stmt2->fetch(PDO::FETCH_ASSOC);
                $stmt2 = $database->execute("SELECT set_name, set_value FROM settings WHERE set_reference=$slave_id or set_reference=0"); // For header query
                //$cnt = 0;
                $results_arr["header"] = array();
                $results_arr["header"]["node_number"] = $slave_id;
                while ($rowHeader = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $results_arr["header"][$rowHeader["set_name"]] = $rowHeader["set_value"];
                }

                $results_arr["text_align"]=array('center', 'right', 'right', 'right', 'right', 'right', 'right', 'right', 'center');
                $results_arr["depth"] = array(0,0,0,0,0,0,0);
                $cnt = 0;
                $stmt2 = $database->execute("SELECT depth FROM inplace_depth WHERE slave_no=$slave_id ORDER BY channel_no");
                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $results_arr["depth"][$cnt] = -1 * $row["depth"];
                    $cnt++;
                }
            }
            elseif($redirect == "vw_list")
                $results_arr["text_align"]=array('', 'center', 'right');
            else
                $results_arr["text_align"]=array('center', 'right', 'center', 'left');
            //$curtime = time();
            
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //$last_update = getTimeText($row['date_time'], $curtime);
        
                if($redirect == "incl_list") {
                    if($channel_id == "x")
                        $alert_item=array(
                            "node_no" => $row['slave_no'],
                            "x1" => ($row['x1'] == ''?round($row['x7']-$rowMin['x7'],2):round($row['x1']-$rowMin['x1'],2)),
                            "x1 Raw" => ($row['x1'] == ''?round($row['x7'],2):round($row['x1'],2)),
                            "x2" => ($row['x2'] == ''?round($row['x7']-$rowMin['x7'],2):round($row['x2']-$rowMin['x2'],2)),
                            "x2 Raw" => ($row['x2'] == ''?round($row['x7'],2):round($row['x2'],2)),
                            "x3" => ($row['x3'] == ''?round($row['x7']-$rowMin['x7'],2):round($row['x3']-$rowMin['x3'],2)),
                            "x3 Raw" => ($row['x3'] == ''?round($row['x7'],2):round($row['x3'],2)),
                            "x4" => ($row['x4'] == ''?round($row['x7']-$rowMin['x7'],2):round($row['x4']-$rowMin['x4'],2)),
                            "x4 Raw" => ($row['x4'] == ''?round($row['x7'],2):round($row['x4'],2)),
                            "x5" => ($row['x5'] == ''?round($row['x7']-$rowMin['x7'],2):round($row['x5']-$rowMin['x5'],2)),
                            "x5 Raw" => ($row['x5'] == ''?round($row['x7'],2):round($row['x5'],2)),
                            "x6" => ($row['x6'] == ''?round($row['x7']-$rowMin['x7'],2):round($row['x6']-$rowMin['x6'],2)),
                            "x6 Raw" => ($row['x6'] == ''?round($row['x7'],2):round($row['x6'],2)),
                            "x7" => round($row['x7']-$rowMin['x7'],2),
                            "x7 Raw" => round($row['x7'],2),
                            "record_time" => date("d/m/Y", strtotime($row['record_time'])),
                            "remarks" => getTimeText($row['record_time']),
                        );
                    else
                        $alert_item=array(
                            "node_no" => $row['slave_no'],
                            "y1" => ($row['y1'] == ''?round($row['y7']-$rowMin['y7'],2):round($row['y1']-$rowMin['y1'],2)),
                            "y1 Raw" => ($row['y1'] == ''?round($row['y7'],2):round($row['y1'],2)),
                            "y2" => ($row['y2'] == ''?round($row['y7']-$rowMin['y7'],2):round($row['y2']-$rowMin['y2'],2)),
                            "y2 Raw" => ($row['y2'] == ''?round($row['y7'],2):round($row['y2'],2)),
                            "y3" => ($row['y3'] == ''?round($row['y7']-$rowMin['y7'],2):round($row['y3']-$rowMin['y3'],2)),
                            "y3 Raw" => ($row['y3'] == ''?round($row['y7'],2):round($row['y3'],2)),
                            "y4" => ($row['y4'] == ''?round($row['y7']-$rowMin['y7'],2):round($row['y4']-$rowMin['y4'],2)),
                            "y4 Raw" => ($row['y4'] == ''?round($row['y7'],2):round($row['y4'],2)),
                            "y5" => ($row['y5'] == ''?round($row['y7']-$rowMin['y7'],2):round($row['y5']-$rowMin['y5'],2)),
                            "y5 Raw" => ($row['y5'] == ''?round($row['y7'],2):round($row['y5'],2)),
                            "y6" => ($row['y6'] == ''?round($row['y7']-$rowMin['y7'],2):round($row['y6']-$rowMin['y6'],2)),
                            "y6 Raw" => ($row['y6'] == ''?round($row['y7'],2):round($row['y6'],2)),
                            "y7" => round($row['y7']-$rowMin['y7'],2),
                            "y7 Raw" => round($row['y7'],2),
                            "record_time" => date("d/m/Y", strtotime($row['record_time'])),
                            "remarks" => getTimeText($row['record_time']),
                        );
                }
                elseif($redirect == "vw_list")
                    $alert_item=array(
                        "row_id" => $row['row_id'],
                        // "slave_no" => $row['slave_no'],
                        "channel_no" => $row['channel_no'],
                        "data" => $row['data'],
                        "record_time" => date("d/m/y H:i:s", strtotime($row['record_time'])),
                        "remarks" => getTimeText($row['record_time']),
                    );
                else
                    $alert_item=array(
                        "slave_no" => $row['slave_no'],
                        "data" => $row['avg_data'],
                        "record_time" => date("d/m/Y", strtotime($row['record_time'])),
                        "remarks" => getTimeText($row['record_time']),
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
                array("message" => "No records found. Statement exec error QR: ", "records" => null)
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