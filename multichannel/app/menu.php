<div class="ui fixed inverted menu">
    <div class="ui container">
      <a href="#" class="header item">
        <img class="logo" src="images/logo.jpg">
        Multichannel DataLog
      </a>
      <?php if ($session_user_type == 2) { ?>
        <a href="?page=home" class="item"><i class="home icon"></i>Home</a>
      <?php } else { ?>
        <a class="item" href="?page=inclsetup"><i class="exchange icon"></i>Inclino Setup</a>
      <?php } ?>
      <a href="?page=logout" class="item right aligned"><i class="logout icon"></i>Logout</a>
    </div>
  </div>
