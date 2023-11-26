<?php
    require_once '../app/model/db.php';
    $database = new Database();

   if(isset($_FILES['csvfile'])){
      $errors= array();
      $file_name = $_FILES['csvfile']['name'];
      $file_size =$_FILES['csvfile']['size'];
      $file_tmp =$_FILES['csvfile']['tmp_name'];
      $file_type=$_FILES['csvfile']['type'];
      $file_name_arr = explode('.',$_FILES['csvfile']['name']);
      $file_ext=strtolower(end($file_name_arr));
      
      $extensions= array("csv");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a CSV file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be less than 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"files/".$file_name);
         echo "<li> Success. ";
         $row = 0;
         $pass_count = 0;
         $fail_count = 0;
         $mode = "VW"; // or IN
         if (($handle = fopen("files/".$file_name, "r")) !== FALSE) {
           while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
             $num = count($data);
             if($num > 2) {
                if($data[2] == "VALUE")
                    $mode = "VW";
                elseif($data[2] == "SENS NO")
                    $mode = "IN";
                else {
                    $record_time = $data[0];
                    $record_time = strtotime($record_time); 
                    $record_time = date('Y-m-d h:i:s', $record_time); 
                    if($mode == "VW") {
                        $slave_no = intval($data[1]);
                        $channel_no = $slave_no;
                        if($slave_no > 10) {
                            $avg_data = 0 + $data[4];
                            $slave_no = intval(($slave_no - 11) / 3) + 4;
                            if($avg_data != 0) {
                                $query = "INSERT INTO vwire_dd (record_time, slave_no, data, channel_no) VALUES ('$record_time', $slave_no, $avg_data, $channel_no)";
                                $stmt = $database->execute($query);
                            
                                if( $stmt->rowCount() > 0 )
                                    $pass_count++;
                                else
                                    $fail_count++;
                            }
                        }
                        else {
                            $avg_data = 0 + floatval($data[2]);
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
                            }
                            if($avg_data != 0) {
                                $query = "INSERT INTO vwire_dd (record_time, slave_no, data, channel_no) VALUES ('$record_time', $slave_no, $avg_data, $channel_no)";
                                $stmt = $database->execute($query);
                            
                                if( $stmt->rowCount() > 0 )
                                    $pass_count++;
                                else
                                    $fail_count++;
                            }
                        }
                    }
                    else { // INPlace
                        $slave_no = intval($data[1]);
                        $channel_no = intval($data[2]);
                        $x_val = 0;
                        if($num > 3)
                            $x_val = floatval($data[3]);
                        $y_val = 0;
                        if($num > 4)
                            $y_val = floatval($data[4]);
                        // NOT NEEDED as pendrive has org channel no : $slave_no = $slave_no - 57;
                        $query = "INSERT INTO inplace_dd (record_time, slave_no, x_data, y_data, channel_no) VALUES ('$record_time', $slave_no, $x_val, $y_val, $channel_no)";
                        $stmt = $database->execute($query);
                    
                        if( $stmt->rowCount() > 0 )
                            $pass_count++;
                        else
                            $fail_count++;
                        
                    }
                    $row++;
                }
             }
           }
            echo "<li> Total : $row   Pass : $pass_count   Fail : $fail_count   Skipped : ".($row - ($pass_count+$fail_count));
            fclose($handle);
         }
         unlink("files/".$file_name);
      }else{
         foreach($errors as $val)
            echo "<li>".$val;
      }
   }
?>