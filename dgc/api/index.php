<?php 
  session_start();

  require_once '../app/model/db.php';

  $redirect = getValue("function", true);
  if (isset($_SESSION['userid']))
  {
      $session_user_id = $_SESSION['userid'];
      $session_user_type = $_SESSION['usertype'];
  }
  else {
      $session_user_id = 0;
      $session_user_type = 0;
  }

  if($session_user_type == 1) { // Admin
      require "./admin.php";
  }
  elseif($session_user_type == 0) { // User
      require "./user.php";
  }
  else { // Not Logged
      echo "Restricted Area!! You cannot access this page => ";
      die();
  }

?>  
  