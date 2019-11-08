<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['username'] && !$_SESSION['password']) {
  header("location:index.php");
}
else{
  $user = $_SESSION['username'];
  $pass =  $_SESSION['password'];
  $enpass = md5($pass);

  $data = mysql_query("SELECT * FROM siswa WHERE username = '$user' AND password = '$enpass'");
  $isi = mysql_fetch_array($data);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Home</title>
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
    <a href="home.php" class="logo">
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
        <li class="user-menu"><a href="#"><i><?php echo $isi['nama']; ?></i></a></li>
        <li class="user-menu"><a href="home.php"><i class="fa fa-home"></i></a></li>
        <li class="user-menu"><a href="logout.php"><b>LOGOUT</b></a></li>
        </ul>
      </div>
    </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar" style="height:auto">
        <ul class="sidebar-menu">
          <li class="treeview active">
            <a href="home.php" style="font-weight:bold;">
              <i class="fa fa-home"></i>
              <span>BERANDA</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="quiz.php" style="font-weight:bold">
              <i class="fa fa-pencil"></i>
              <span>UJIAN</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="profil.php" style="font-weight:bold">
              <i class="fa fa-user"></i>
              <span>PROFIL</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
        </ul>
      </section>
    </aside>

    <div class="content-wrapper">
    	<section class="content-header">
          
    	</section>
    	<section class="content">
      <div class="jumbotron bg-navy" style="border-radius: 10px">
            <img src="images/yplp.png" style="width: 250px;margin:30px">
            <h3 style="margin: 30px">Hai <?php echo $isi['nama']; ?>,</h3>
            <h2 style="margin: 30px">
              Selamat Datang di E-Xam, Ujian Online SMK PGRI 05 Jember
            </h2>
            <h1 align="right" style="color:#fff; font-weight: bold; background:darkblue;padding-right: 50px" id="jam"></h1>
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
<script type="text/javascript">
 window.onload = function() { jam(); }
 
 function jam() {
  var e = document.getElementById('jam'),
  d = new Date(), h, m, s;
  h = d.getHours();
  m = set(d.getMinutes());
  s = set(d.getSeconds());
 
  e.innerHTML = h +':'+ m +':'+ s;
 
  setTimeout('jam()', 1000);
 }
 
 function set(e) {
  e = e < 10 ? '0'+ e : e;
  return e;
 }
</script>
</body>
</html>