<?php

session_start();
include_once('dbconfig.php');
if (isset($_SESSION['user_session']) != "") {
  if (isset($_SESSION['url']) and $_SESSION['url'] == $default_url_set) {
    header("Location: dashboard.php");
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>User System</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" media="screen" href="css/style.css">
  <script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
  <script type="text/javascript" src="validation.min.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css" media="screen">
  <script type="text/javascript" src="script.js"></script>

</head>

<body>
  <div id="particles-js">
    <div class="signin-form">

      <div class="container">


        <form class="form-signin" method="post" id="login-form">

          <center>

            <span class="form-signin-heading" style="font-size:30px">Automatic Water Level Recorder</span>
          </center>
          <hr />

          <div id="error">
            <!-- error will be shown here ! -->
          </div>

          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email address" name="user_email" id="user_email" />
            <span id="check-e"></span>
          </div>

          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
          </div>

          <hr />

          <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
              <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
            </button>

          </div>
          <div class="form-group" style="color: black;">
            For Info :- <a href="mailto:info@awlr.in">info@awlr.in</a>
          </div>

        </form>

      </div>

    </div>

  </div>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="particles.js"></script>
  <script src="js/app.js"></script>

  <!-- stats.js -->
  <script src="js/lib/stats.js"></script>
</body>

</html>