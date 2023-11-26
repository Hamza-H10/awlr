<?php
// required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Asia/Kolkata');
 
// include database and object files
require_once 'db.php';
 
// instantiate database and product object
$database = new Database();

$in_string =  $database->getValue("sh@rein"); 
$database->execute("SET time_zone='+5:30';");

//echo "String = ".$in_string."<br>";

$in_array = explode("><", trim($in_string,"<>"));

$fail_count = 0;
$pass_count = 0;

foreach($in_array as $value) {
    $channel_no = $x_val = $y_val = $slave_no = null;
    
    sscanf($value,"%d,%fY%f,%d", $slave_no, $x_val, $y_val, $channel_no);
    if($channel_no == null) {
        $channel_no = $slave_no;
        switch($slave_no) {
            case ($slave_no <= 3):
                $slave_no = 1;
                break;
            case ($slave_no > 3 && $slave_no <= 6):
                $slave_no = 2;
                break;
            case ($slave_no > 6 && $slave_no <= 10):
                $slave_no = 3;
                break;
            case ($slave_no > 10 && $slave_no <= 100):
                $slave_no = intval(($slave_no - 11) / 3) + 4;
                break;
            case ($slave_no > 100):
                $channel_no = $slave_no - 100;
                $slave_no = 0;
                break;
        }
        $query = "INSERT INTO vwire_dd (slave_no, data, channel_no) VALUES ($slave_no, $x_val, $channel_no)";
        //echo "SLAVE=$slave_no, Data=$x_val, Channel=$channel_no<br>";
    }
    else {
        $slave_no = $slave_no - 57;
        //echo "SLAVE=$slave_no, X=$x_val, Y=$y_val, Channel=$channel_no<br>";
        $query = "INSERT INTO inplace_dd (slave_no, x_data, y_data, channel_no) VALUES ($slave_no, $x_val, $y_val, $channel_no)";
    }
    $stmt = $database->execute($query);

    if( $stmt->rowCount() > 0 )
        $pass_count++;
    else
        $fail_count++;

}
http_response_code(200);

echo "Total = ".($pass_count+$fail_count)." Success = ".$pass_count." Failed = ".$fail_count;