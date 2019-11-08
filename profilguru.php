<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

ini_set("display_errors","off");
if (!$_SESSION['usernameguru'] && !$_SESSION['passwordguru']) {
  header("location:index.php");
}
else{
  $user = $_SESSION['usernameguru'];
  $pass =  $_SESSION['passwordguru'];
  $enpass = md5($pass);

  $data = mysql_query("SELECT * FROM guru WHERE username = '$user' AND password = '$enpass'");
  $isi = mysql_fetch_array($data);

  $ehem = mysql_num_rows(mysql_query("SELECT * FROM membuat WHERE mapel = '$isi[mapel]'"));
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Profil</title>
  <link rel="icon" href="images/exam.png">
	<link rel="stylesheet" type="text/css" href="hover/hover.css">
	<link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/AdminLTE.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/skins/_all-skins.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>
<body class="skin-blue sidebar-mini wysihtml5-supported sidebar-collapse">
<div class="wrapper">
	<header class="main-header">
    <a href="homeguru.php" class="logo">
      <span class="logo-mini">
        <b>E</b>-X
      </span>
      <span class="logo-lg">
        <b>E</b>-Xam
      </span>
    </a>

    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle Navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav pull-right">
        <li class="user-menu"><a href="#"><i><?php echo $isi[1]; ?></i></a></li>
        <li class="user-menu"><a href="homeguru.php"><i class="fa fa-home"></i></a></li>
        <li class="user-menu"><a href="logout.php"><b>LOGOUT</b></a></li>
        </ul>
      </div>
    </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar" style="height:auto">
        <ul class="sidebar-menu">
          <li class="treeview">
            <a href="homeguru.php" style="font-weight:bold;">
              <i class="fa fa-home"></i>
              <span>BERANDA</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="quizguru.php" style="font-weight:bold">
              <i class="fa fa-pencil"></i>
              <span>UJIAN</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <li class="active">
            <a href="profilguru.php" style="font-weight:bold">
              <i class="fa fa-user"></i>
              <span>PROFIL</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <?php if ($ehem == 0) {}else{ ?>
          <li>
            <a href="bankSoal.php" style="font-weight:bold">
              <i class="fa fa-bank"></i>
              <span>BANK SOAL</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <?php } ?>
        </ul>
      </section>
    </aside>

    <div class="content-wrapper">
    	<section class="content-header">
          <h3><i class="fa fa-user"></i> Profil <?php echo $isi[1]; ?></h3>
    	</section>
    	<section class="content">
        <div class="row">
          <div class="col-md-6">
        		<div class="box box-primary">
    	    		<div class="box-body">
    	    				<div class="form-group">
                    <input type="hidden" id="kd" value="<?php echo $isi[0]; ?>">
                    <h4>KODE GURU : <b><?php echo $isi[0]; ?></b></h4>
                    <h4>NAMA : <b><?php echo $isi[1]; ?></b></h4>
                    <input type="text" class="form-control" id="username" placeholder="USERNAME.." value="<?php echo $isi[2]; ?>"><br>
                    <input type="password" class="form-control" id="password" placeholder="PASSWORD BARU.."><br>
                    <input type="password" class="form-control" id="confirm" placeholder="KONFIRMASI PASSWORD BARU.."><br>
                    <div id="hasil" style="display: none"></div>
                    <button type="button" id="update" class="btn btn-flat btn-lg btn-warning"><i class="fa fa-upload"></i> UPDATE</button>
                  </div>
    	    		</div>
    	    	</div>
          </div>
        </div>
    	</section>
    </div>
<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>E-Xam</b> V 2.0.0
	</div>
	Copyright 2016, Syaikhu Rizal - 
	<strong>SMK PGRI 05 Jember</strong>
</footer>
</div>
<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
  <script src="mybootstrap/js/bootstrap.js"></script>
  <script src="jquery-ui-1.12.1/jquery-ui.js"></script>
  <script src="bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="slimScroll/jquery.slimscroll.min.js"></script>
  <script src="AdminLTE/js/app.min.js"></script>
<script>
$(document).ready(function() {
  $('#update').click(function() {
    var kd = $('#kd').val();
    var username = $('#username').val();
    var password = $('#password').val();
    $.ajax({
      url: 'updateGuru.php',
      type: 'GET',
      data: "kd="+kd+"&username="+username+"&password="+password,
      success:function(data){
        $('#hasil').html(data);
        window.location="guru.php";
      }
    });
  });
});
</script>
</body>
</html>