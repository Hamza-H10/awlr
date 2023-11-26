<?php include('include/header.php'); ?>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<style>
  .cwhite {
    color: #FFFFFF
  }

  .form-control {
    display: block;
    width: 100%;
    height: 28px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fbf1ae;
    background-image: none;

  }
</style>
<div class="body-container">
  <div class="container">
    <div class="row">
      <div class="col-md-12" style="margin-top:15px">

        <div class="row" style="min-height:300px">
          <div class="col-md-12" style="margin-top:15px">


            <table id="datatables1" class="table table-striped table-bordered dataTable" data-page-length='10'>


              <thead>
                <tr>

                  <th colspan="6" style=" background-color:#FFF; margin:0px; padding:0px"> <a href="#myModal1" role="button" class="" title="Edit" data-toggle="modal" onclick="creat();"><button class="btn btn-success btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a></th>


                </tr>
              </thead>

              <thead>
                <tr>

                  <th>Sr No.</th>

                  <th>Name</th>
                  <th>Email</th>
                  <th>File</th>

                  <th>Role</th>
                  <th>Perform</th>
                </tr>
              </thead>


              <tbody>




                <?php
                $rown = 0;
                $stmt = $db->prepare("SELECT * FROM tbl_users order by user_id asc  ");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $rown = $rown + 1;

                ?>

                  <tr>

                    <td><?php echo $rown ?></td>
                    <td><?php echo $row['user_name'] ?></td>

                    <td><?php echo $row['user_email'] ?></td>

                    <td>
                      <?php echo $row['mobile'] ?>

                    </td>
                    <td>
                      <?php if ($row['role'] == 0) {
                        echo $role = 'User';
                      } else {
                        echo  $role = 'Admin';
                      }  ?>

                    </td>
                    <td><span style="display:none">
                        <input type="text" id="uid_<?= $row['user_id'] ?>" value="<?= $row['user_id'] ?>" />
                        <input type="text" id="name_<?= $row['user_id'] ?>" value="<?= $row['user_name'] ?>" />
                        <input type="text" id="email_<?= $row['user_id'] ?>" value="<?= $row['user_email'] ?>" /> <input type="text" id="mobile_<?= $row['user_id'] ?>" value="<?= $row['mobile'] ?>" />
                        <input type="text" id="role_<?= $row['user_id'] ?>" value="<?= $row['role'] ?>" />
                      </span>
                      <a href="#myModal" role="button" class="" title="Edit" data-toggle="modal" onclick="edit('<?= $row['user_id'] ?>');"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button></a>

                      <?php if ($rown == 1) {
                      ?>
                        <a>
                          <button class="btn btn-default btn-xs titleModal" data-placement="top" title="Default Account ,Delete is disable for this user" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span></button></a>
                      <?php
                      } else { ?>
                        <a onclick="delete_user(<?= $row['user_id'] ?>);">
                          <button class="btn btn-danger btn-xs" title="Delete" data-title="Delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button></a>
                      <?php } ?>


                    </td>


                  </tr>
                <?php } ?>






              </tbody>
            </table>
            <input class="hidden" type="text" id="delete_id" />

          </div>
        </div>

      </div>
    </div>

  </div>

  <div class="panel-footer" style="position: fixed;
width: 100%;
bottom: 0px;">

  </div>
</div>

<style>
  .modal-dialog {
    width: 300px !important;

  }
</style>

<div id="myModal" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">Edit User</h4>

      </div>

      <div class="modal-body" id="modal-body">


        <form name="edit_form" id="edit_form">

          <div class="form-group" style="margin-top:5px">
            <input id="curuid" name="id" class="hidden" required="required" type="text">
            <input id="curname" name="name" class="form-control" placeholder="User Name" required="required" type="text">

          </div>

          <div class="form-group" style="margin-top:5px">
            <input id="curmobile" name="mobile" class="form-control" placeholder="User File" required="required" type="tel">

          </div>

          <div class="form-group" style="margin-top:5px">
            <input id="curemail" name="email" class="form-control" placeholder="User Email" required="required" type="email">

          </div>



          <div class="form-group" style="margin-top:5px">
            <label>Role:</label>

            <select id="currole" name="role" class="form-control" title="Select Role">
              <option value="0">User</option>
              <option value="1">Admin</option>
            </select>

          </div>

          <div class="form-group" style="margin-top:5px">
            <center> <a onclick="submit_edit()" class="btn btn-success " data-dismiss="modal">Save Data</a></center>

          </div>

        </form>


      </div>

      <div class="modal-footer">





      </div>

    </div>

  </div>

</div>




<div id="myModal1" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">Create User</h4>

      </div>

      <div class="modal-body" id="modal-body">
        <form name="create_form" id="creat_form">

          <div class="form-group" style="margin-top:5px">
            <input id="adname" name="name" class="form-control" placeholder="User Name" required="required" type="text">

          </div>

          <div class="form-group" style="margin-top:5px">
            <input id="admobile" name="mobile" class="form-control" placeholder="User File" required="required" type="tel">

          </div>

          <div class="form-group" style="margin-top:5px">
            <input id="ademail" name="email" class="form-control" placeholder="User Email" required="required" type="email">

          </div>

          <div class="form-group" style="margin-top:5px">
            <input id="adpassword" name="password" class="form-control" placeholder="User Password" required="required" type="password">

          </div>

          <div class="form-group" style="margin-top:5px">


            <select name="role" id="adrole" class="form-control" title="Select Role">
              <option value="0">User</option>
              <option value="1">Admin</option>
            </select>

          </div>

          <div class="form-group" style="margin-top:5px">
            <center> <a onclick="submit_creat()" class="btn btn-success " data-dismiss="modal">Save Data</a></center>

          </div>

        </form>


      </div>

      <div class="modal-footer">

      </div>

    </div>

  </div>

</div>




<div id="confirm_box" style="display:none">
  <div class="confirmModal_content">
    Are You Sure! To Delete User
  </div>
  <div class="confirmModal_footer">
    <button type="button" class="btn btn-primary" data-confirmmodal-but="ok">Confirm</button>
    <button type="button" class="btn btn-default" data-confirmmodal-but="cancel">Cancel</button>
  </div>
</div>

<div id="info" style="display:none">

</div>

<script>
  function edit(user_id) {
    var gid = document.getElementById('uid_' + user_id).value;
    var gname = document.getElementById('name_' + user_id).value;
    var gemail = document.getElementById('email_' + user_id).value;
    var gmobile = document.getElementById('mobile_' + user_id).value;
    var grole = document.getElementById('role_' + user_id).value;

    $("#curuid").val(gid);
    $("#curname").val(gname);
    $("#curemail").val(gemail);
    $("#curmobile").val(gmobile);
    $("#currole").val(grole);

  }



  function submit_creat() {
    var spassword = document.getElementById('adpassword').value;
    var sname = document.getElementById('adname').value;
    var semail = document.getElementById('ademail').value;
    var smobile = document.getElementById('admobile').value;
    var srole = document.getElementById('adrole').value;

    xmlHttp = GetXmlHttpObject()
    if (xmlHttp == null) {
      alert("Browser does not support HTTP Request")
      return
    }
    var url = "<?= url() ?>process/user.php" //Edit this Line Ac to Your page
    url = url + "?password=" + spassword + "&name=" + sname + "&email=" + semail + "&mobile=" + smobile + "&role=" + srole + "&qry=create"

    xmlHttp.onreadystatechange = stateChanged
    xmlHttp.open("post", url, true)
    xmlHttp.send(null)
  }

  function stateChanged() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
      document.getElementById("info").innerHTML = xmlHttp.responseText;

      notify_box();
      location.reload();

    } else {
      document.getElementById("info").innerHTML = "<center>Please Wait While We Process Your Request <img src=<?= url() ?>images/loader.gif height=20 /></center>";

      notify_box();
    }
  }

  function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
      // Firefox, Opera 8.0+, Safari
      xmlHttp = new XMLHttpRequest();
    } catch (e) {
      //Internet Explorer
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    return xmlHttp;
  }





  function submit_edit() {
    var sid = document.getElementById('curuid').value;
    var sname = document.getElementById('curname').value;
    var semail = document.getElementById('curemail').value;
    var smobile = document.getElementById('curmobile').value;
    var srole = document.getElementById('currole').value;

    xmlHttp = GetXmlHttpObject()
    if (xmlHttp == null) {
      alert("Browser does not support HTTP Request")
      return
    }
    var url = "<?= url() ?>process/user.php" //Edit this Line Ac to Your page
    url = url + "?id=" + sid + "&name=" + sname + "&email=" + semail + "&mobile=" + smobile + "&role=" + srole + "&qry=update"

    xmlHttp.onreadystatechange = stateChanged
    xmlHttp.open("post", url, true)
    xmlHttp.send(null)
  }

  function stateChanged() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
      document.getElementById("info").innerHTML = xmlHttp.responseText;

      notify_box();
      location.reload();

    } else {
      document.getElementById("info").innerHTML = "<center>Please Wait While We Process Your Request <img src=<?= url() ?>images/loader.gif height=20 /></center>";

      notify_box();
    }
  }

  function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
      // Firefox, Opera 8.0+, Safari
      xmlHttp = new XMLHttpRequest();
    } catch (e) {
      //Internet Explorer
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    return xmlHttp;
  }

  function notify_box() {
    $('#info').notifyModal({
      duration: 2500,
      placement: 'center',
      overlay: true,
      type: 'notify',
      icon: false,
      onClose: function() {}
    });


  }

  function delete_user(id) {
    $('#delete_id').val(id);
    $('#confirm_box').confirmModal({
      topOffset: 0,
      top: 0,
      onOkBut: function() {
        delete_ok()
      },
      onCancelBut: function() {},
      onLoad: function() {},
      onClose: function() {}
    });
  }

  function delete_ok() {
    var did = document.getElementById('delete_id').value;


    xmlHttp = GetXmlHttpObject()
    if (xmlHttp == null) {
      alert("Browser does not support HTTP Request")
      return
    }
    var url = "<?= url() ?>process/user.php" //Edit this Line Ac to Your page
    url = url + "?id=" + did + "&qry=delete"

    xmlHttp.onreadystatechange = stateChanged
    xmlHttp.open("post", url, true)
    xmlHttp.send(null)
  }

  function stateChanged() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
      document.getElementById("info").innerHTML = xmlHttp.responseText;

      notify_box();
      location.reload();

    } else {
      document.getElementById("info").innerHTML = "<center>Please Wait While We Process Your Request <img src=<?= url() ?>images/loader.gif height=20 /></center>";

      notify_box();
    }
  }

  function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
      // Firefox, Opera 8.0+, Safari
      xmlHttp = new XMLHttpRequest();
    } catch (e) {
      //Internet Explorer
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    return xmlHttp;


  }
</script>
<?php include('include/footer.php'); ?>