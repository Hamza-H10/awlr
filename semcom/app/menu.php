<div class="ui fixed inverted menu">
    <div class="ui container">
      <a href="#" class="header item">
        <img class="logo" src="images/logo.jpg">
        SemCom
      </a>
      <a href="?page=home" class="item"><i class="home icon"></i>Home</a>
      <?php if ($session_user_type == 2) { ?>
        <a class="item" href="?page=vwire"><i class="random icon"></i>Piezo</a>
        <a class="item" href="?page=loadcell"><i class="chart line icon"></i>Load Cell</a>
        <a class="item" href="?page=inclino"><i class="exchange icon"></i>Inclino</a>
      <?php } else { ?>
        <a class="item" href="?page=inclsetup"><i class="exchange icon"></i>Inclino Setup</a>
      <?php } ?>
      <a href="?page=logout" class="item right aligned"><i class="logout icon"></i>Logout</a>
    </div>
  </div>
