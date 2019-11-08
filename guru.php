<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if ($_SESSION['usernameguru'] != "" && $_SESSION['passwordguru'] != "") {
	header("location:homeguru.php");
}else{
	// header("location:guru.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Login Guru</title>
	<link rel="icon" href="images/exam.png">
	<link rel="stylesheet" type="text/css" href="hover/hover.css">
	<link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/AdminLTE.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/skins/_all-skins.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/font-awesome.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url(images/siaga.jpg);">
<div style="background-color: rgba(0,0,0,0.7);min-height: 600px;display: block;position: absolute;margin: auto;top: 0;bottom: 0;left: 0;right: 0;">
	<br>
	<div class="row">
		<div class="col-md-8">

		<div class="modal fade" role="dialog" id="modalLogin">
			<div class="modal-dialog">
			<div class="login-box" id="kotak_login" style="margin-top: -5px;margin-bottom: -10px">
		<div class="login-logo">
			<a href="index.php" style="color:cyan"><b>Login</b> Guru</a>
		</div>
		<div class="login-box-body" style="background-color: rgba(300,300,300,0.6)">
				<div class="form-group has-feedback">
					<input type="text" name="gurusername" id="gurusername" class="form-control" placeholder="Username..">
					<span class="fa fa-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="gurpassword" id="gurpassword" class="form-control" placeholder="Password..">
					<span class="fa fa-lock form-control-feedback"></span>
				</div>
				<button type="button" name="submitGuru" id="submitGuru" class="hvr-back-pulse btn btn-flat btn-block btn-primary"><b>MASUK</b></button>
				<hr>
				<center><a href="daftarguru.php"><button type="button" class="hvr-grow-rotate btn btn-link btn-default"><i class="fa fa-edit"></i> DAFTAR</button></a></center>
				<br>
				<center>
					<div id="loading">
					
					</div>
				</center>
				
        <div id="hasilGuru" style="display: none"></div>			
		</div>
	</div>
			</div>
		</div>

		 <center>

      <br><br>
      <h1><b style="color:white;font-family: kristen itc,cursive;font-size: 60px">E-Xam</b></h1>
      <br><hr>
      <h1 style="color:white;font-family: mv boli, cursive"><b>Bergabung di E-Xam</b></h1>
      <h1 style="color:white;font-family: mv boli, cursive"><b>Laksanakan Ujian Yang Sebenarnya</b></h1><hr><br>
      <h2 style="color: white;font-family: mv boli, cursive"><b>GURU</b></h2>
      <button type="button" data-toggle="modal" data-target="#modalLogin" class="btn btn-flat btn-lg hvr-outline-out" style="padding-left: 50px;padding-right: 50px; color:white;background-color: rgba(100,100,100,0.8);">Masuk | Daftar</button><br><br><br><br><br>

      <marquee><h4 class="hvr-pulse-grow" style="color:white">----- Ujian Daring SMK PGRI 05 Jember ----</h4></marquee>
    	</center>

		</div>
		<div class="col-md-4">
			<div class="hvr-bob" style="margin-top:20px;background-color: rgba(0,0,0,0.5);padding: 15px;color:white;text-align: center">
				<img src="images/yplp.png" style="width: 200px" class="hvr-buzz-out">
				<h1>E-Xam</h1>
				<h4>
					Adalah aplikasi ujian daring karya siswa SMK PGRI 05 Jember.
				</h4>
				<h4>
					Aplikasi ini dibuat untuk menyelenggarakan ujian yang lebih efektif dan efisien serta hemat biaya. Siswa juga lebih sedikit kemungkinan mencontek, dan membuat siswa lebih mandiri mengerjakan soal ujian.
				</h4>
				<br>
				<h4>
					<b><i>talk less, do more</i></b><br>
					<b><i>cheat less, think more</i></b>
				</h4>
			</div>
		</div>
	</div>
</div>
<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
	<script src="mybootstrap/js/bootstrap.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
	$('#submitGuru').click(function() {
		var gurusername = $('#gurusername').val();
		var gurpassword = $('#gurpassword').val();
    if (gurusername == "" || gurpassword == "") {}
    else{
      $('#loading').html("<img src='images/progress.gif' style='width:250px'>");
      $.ajax({
      url: 'loginguru.php',
      type: 'GET',
      data: "usernameguru="+gurusername+"&passwordguru="+gurpassword,
      success:function(dataguru){
        $('#hasilGuru').html(dataguru);
        var hasile = $('#hasilGuru').text();
        if (hasile == '1') {
          window.location='homeguru.php';
        }
        else{
          window.location='index.php';
        }
      }
    });
    }
	});

});
</script>
</body>
</html>