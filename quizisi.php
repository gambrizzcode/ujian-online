<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['usernameguru'] && !$_SESSION['passwordguru']) {
  header("location:index.php");
}
else{
  if ($_SESSION['usernameguru'] == "ADMIN") {header("location:admin.php");}else{}

  $user = $_SESSION['usernameguru'];
  $pass =  $_SESSION['passwordguru'];
  $enpass = md5($pass);

  $data = mysql_query("SELECT * FROM guru WHERE username = '$user' AND password = '$enpass'");
  $isi = mysql_fetch_array($data);

  $id_membuat = $isi[0]."-".$isi['mapel'];

  $ehem = mysql_num_rows(mysql_query("SELECT * FROM membuat WHERE mapel = '$isi[mapel]'"));
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Isi Soal</title>
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
		  <li class="active">
			<a href="quizguru.php" style="font-weight:bold">
			  <i class="fa fa-pencil"></i>
			  <span>UJIAN</span>
			  <span class="pull-right-container">
				<i class="fa fa-angle-double-right pull-right"></i>
			  </span>
			</a>
		  </li>
		  <li>
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
		  <h2><i class="fa fa-edit"></i> Buat Soal</h2>
		</section>
		<section class="content">
			<div class="row">
		<div class="col-md-12">
		  <div class="box box-primary" id="kotak_topik">
			<div class="box-body">
				  <form id="uploadForm" method="POST" enctype="multipart/form-data" action="simpanSoal.php">
				  <?php
				  $kode = md5($isi[0].time()).time();
				  ?>
				  <input type="hidden" id="kd_soal" name="kd_soal" value="<?php echo $kode; ?>">
				  <input type="hidden" id="id_ts" name="id_ts" value="<?php echo $_REQUEST['id_ts']; ?>">
				  <?php
				  $soalini = mysql_query("SELECT * FROM soal WHERE id_ts = '$_REQUEST[id_ts]'");
				  $nomor = mysql_num_rows($soalini);
				  ?>
				  <h4>Soal Ke <b><?php echo $nomor+1; ?></b><br>

				  <div class="form-inline">
				  Nama Bab : <input type="text" name="bab" id="bab" class="form-control">
				  </div>

				  <button type="button" class="btn btn-flat btn-lg btn-success pull-right" id="selesai" style="margin-left: 30px">
				  <b>SELESAI <i class="fa fa-check"></i></b>
				  </button>

				  <button type="button" id="bank" class="btn bg-teal btn-flat pull-right btn-lg" style="margin-left: 30px"><i class="fa fa-bank"></i> KE BANK SOAL</button>

				  <button type="button" id="refresh" class="btn btn-default btn-flat pull-right btn-lg"><i class="fa fa-refresh"></i> REFRESH</button>

				  </h4><br>
				  <h4><b>Pertanyaan</b></h4>
				  <textarea name="soal" id="soal"></textarea>
				  <hr>
				  <div class="form-group">
					<div class="btn btn-default btn-flat btn-file">
					  Klik Disini Untuk Menambahkan Gambar &nbsp;&nbsp;&nbsp; <i class="fa fa-file-image-o"></i>
					  <input type="file" class="gambar" name="gambar">
					</div>
				  </div>
				  <br>
				  <div class="form-group">
					<div class="btn btn-default btn-flat btn-file">
					  Klik Disini Untuk Menambahkan Suara / Audio &nbsp;&nbsp;&nbsp; <i class="fa fa-file-audio-o"></i>
					  <input type="file" class="audio" name="audio">
					</div>
				  </div>
					<input type="hidden" name="guambar" id="guambar">
					<input type="hidden" name="uaudio" id="uaudio">
				  <br>
				  <h4><b>Pilihan A</b></h4>
				  <textarea class="form-control ckeditor" id="pila" name="pila"></textarea>
				  <h4><b>Pilihan B</b></h4>
				  <textarea class="form-control ckeditor" id="pilb" name="pilb"></textarea>
				  <h4><b>Pilihan C</b></h4>
				  <textarea class="form-control ckeditor" id="pilc" name="pilc"></textarea>
				  <h4><b>Pilihan D</b></h4>
				  <textarea class="form-control ckeditor" id="pild" name="pild"></textarea>
				  <h4><b>Pilihan E</b></h4>
				  <textarea class="form-control ckeditor" id="pile" name="pile"></textarea>
				  <p></p>
				  <label>KUNCI JAWABAN</label>
				  <select name="kunci" id="kunci" class="form-control">
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
					<option value="E">E</option>
				  </select>
				  <br><br>
				  <button type="submit" class="btn btn-flat btn-lg btn-danger btn-block pull-right" name="go" id="go">
					<b><i class="fa fa-download"></i> SIMPAN <i class="fa fa-arrow-right"></i></b>
				  </button>
				  <div id="hasil"></div>
				  </form>
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
	<script src="ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace('soal');
$(document).ready(function() {
  $('#refresh').click(function() {
	var id_ts = $('#id_ts').val();
	var exp = parseInt($('#exp').val());
	window.location="quizisi.php?id_ts="+id_ts;
  });

  $('#selesai').click(function() {
	window.location="quizgurutampil.php";
  });
  $('#bank').click(function() {
	window.location="bankSoal.php";
  });
  $('.gambar').change(function() {
	var g = $('.gambar').val();
	var p = parseFloat($('.gambar').val().length);
	var gambir = g.slice(12,p);
	$('#guambar').val(gambir);
  });

});
</script>
</body>
</html>