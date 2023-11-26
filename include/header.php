<?php
session_start();
include_once(dirname(__FILE__) . '/../dbconfig.php');
if (!isset($_SESSION['user_session'])) {
  header("Location: index.php");
} elseif (!isset($_SESSION['url']) and $_SESSION['url'] == $default_url_set) {
  header("Location: index.php");
}



$stmt = $db->prepare("SELECT * FROM tbl_users WHERE user_id=:uid");
$stmt->execute(array(":uid" => $_SESSION['user_session']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$core_user_role = $row['role'];
$core_user_email = $row['user_email'];
if ($row['role'] == 0) {
  $page_set = array("setting.php", "user.php");
  if (in_array(basename($_SERVER['PHP_SELF']), $page_set)) {
    header("Location: index.php");
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>User system</title>
  <?php include('css.php'); ?>

</head>
<style>
  .add_field_button,
  .remove_field {
    padding: 5px
  }


  .navbar-default {
    background-image: -webkit-linear-gradient(top, #2e6da4 0, #337ab7 100%) !important;
    background-image: -o-linear-gradient(top, #2e6da4 0, #337ab7 100%) !important;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#2e6da4), to(#337ab7)) !important;
    background-image: linear-gradient(to bottom, #2e6da4 0, #337ab7 100%) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#fff8f8f8', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    background-repeat: repeat-x;

    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .15), 0 1px 5px rgba(0, 0, 0, .075);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .15), 0 1px 5px rgba(0, 0, 0, .075);
    border-bottom: 4px solid #5cb85c !important;
  }

  .navbar-default .navbar-nav>li>a {
    color: #fff !important;
  }

  .navbar-default .navbar-nav>.active>a,
  .navbar-default .navbar-nav>.open>a {
    background-image: -webkit-linear-gradient(top, #5cb85c 0, #617dd3 100%) !important;
    background-image: -o-linear-gradient(top, #5cb85c 0, #617dd3 100%) !important;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#5cb85c), to(#617dd3)) !important;
    background-image: linear-gradient(to bottom, #5cb85c 0, #617dd3 100%) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffdbdbdb', endColorstr='#ffe2e2e2', GradientType=0);
    background-repeat: repeat-x;
    -webkit-box-shadow: inset 0 3px 9px rgba(0, 0, 0, .075);
    box-shadow: inset 0 3px 9px rgba(0, 0, 0, .075);
  }

  .navbar-default .navbar-nav>.active>a,
  .navbar-default .navbar-nav>.active>a:focus,
  .navbar-default .navbar-nav>.active>a:hover {
    color: #fff !important;
    background-color: #e7e7e7 !important;
  }

  .navbar-default .navbar-brand:focus,
  .navbar-default .navbar-brand:hover {
    color: #faec4c !important;
    background-color: transparent !important;
  }

  .navbar-default .navbar-brand {
    color: #fff !important;
  }

  .navbar-default .navbar-nav>li>a:focus,
  .navbar-default .navbar-nav>li>a:hover {
    color: #faec4c !important;
    background-color: transparent;
  }

  .navbar-default .navbar-nav>.open>a,
  .navbar-default .navbar-nav>.open>a:focus,
  .navbar-default .navbar-nav>.open>a:hover {
    color: #faec4c !important;
    background-color: #e7e7e7 !important;
  }

  .panel-footer {
    padding: 10px 15px;
    background-color: #214e75 !important;
    border-top: 3px solid #5ab55a !important;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    margin-top: 80px;
  }
</style>

<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" style="font-family:Arial, Helvetica, sans-serif" href="#">AWLR</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>&nbsp;Hi` <span style="text-transform:capitalize"><?php echo $row['user_name']; ?></span>&nbsp;<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?= url() ?>user-profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
              <li><a href="<?= url() ?>logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav" style="float:right;">
          <?php if ($row['role'] == 0) { ?>
            <li class="<?= active('dashboard.php') ?>"><a href="<?= url() ?>dashboard.php">Dashboard</a></li>
            <li class="<?= active('user.php') ?>"><a href="<?= url() ?>api/user/devices_data.php">Device Data</a></li>
          <?php } else { ?>
            <li class="<?= active('dashboard.php') ?>"><a href="<?= url() ?>dashboard.php">Dashboard</a></li>
            <li class="<?= active('user.php') ?>"><a href="<?= url() ?>user.php">Manage User</a></li>
            <li class="<?= active('user.php') ?>"><a href="<?= url() ?>api/user/">Devices</a></li>
            <!-----<li class="<?= active('setting.php') ?>"><a href="<?= url() ?>setting.php">Setting</a></li>----->
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>