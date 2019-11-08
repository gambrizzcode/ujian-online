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

  $ehem = mysql_num_rows(mysql_query("SELECT * FROM membuat WHERE mapel = '$isi[mapel]'"));
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Edit Soal</title>
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
		  <?php
          if ($ehem == 0) {}else{ ?>
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
		  <h2><i class="fa fa-edit"></i> Soal Anda</h2>
		  <h3><button type="button" id="kembali" class="btn pull-right btn-lg btn-default"><i class="fa fa-chevron-left"></i> KEMBALI</button></h3><br><br>
		</section>

		<section class="content">
			<div class="row">
		  <div class="col-md-12">
			<div class="box box-primary" id="kotak_topik">
			  <div class="box-body">
				<form name="uploadForm" method="POST" enctype="multipart/form-data" action="simpanSoalEdit.php">
				<?php
				$no = 1;
				$datasoal = mysql_query("SELECT * FROM soal WHERE kd_soal = '$_REQUEST[id_soal]'");
				$soalsoal = mysql_fetch_array($datasoal);
		  		?>
				<input type="hidden" name="kd_soal" id="kd_soal" value="<?php echo $soalsoal[0]; ?>">
				<b><?php if($_REQUEST['no'] != ""){echo "Soal No : ".$_REQUEST['no'];}else{} ?></b><br>
				<div class="form-inline">
				Nama Bab : <input type="text" name="bab" id="bab" class="form-control" value="<?php echo $soalsoal['bab']; ?>">
				</div><br>
				<input type="hidden" name="numur" id="numur" value="<?php if($_REQUEST['no'] != ''){echo $_REQUEST['no'];}else{} ?>">
				<h4><textarea id="soal" name="soal" class="ckeditor"><?php echo $soalsoal['soal']; ?></textarea></h4>
				<b>Gambar Lama : </b><br><input type="show/hidden" id="gambarLama" name="gambarLama" value="<?php echo $soalsoal['gambar']; ?>" readonly><br><br><input type="hidden" id="audioLama" name="audioLama" value="<?php echo $soalsoal['audio']; ?>">
				<b>Audio Lama : </b><br>
				<audio autobuffer controls>
					<source src="audio/<?php echo $soalsoal['audio']; ?>">
				</audio>
				<br><br>
				<div class="form-group">
					<div class="btn btn-default btn-flat btn-file">
						Klik Disini Untuk Menambahkan Gambar Baru
						<input type="file" class="gambar" name="gambar">
					</div>
				</div>
				<div class="form-group">
					<div class="btn btn-default btn-flat btn-file">
						Klik Disini Untuk Menambahkan Audio / Suara Baru
						<input type="file" class="audio" name="audio">
					</div>
				</div>
				<br>
				<!-- <input type="hidden" id="guambar" name="guambar"> -->
				<hr><label>Plihan A.</label>
				<textarea name="pila" class="form-control ckeditor" id="pila" placeholder="Masukkan Disini Untuk Jawaban Baru....">
				<?php echo $soalsoal['pila']; ?>
				</textarea>
				<br>

				<hr><label>Plihan B.</label>
				<textarea name="pilb" class="form-control ckeditor" id="pilb" placeholder="Masukkan Disini Untuk Jawaban Baru....">
				<?php echo $soalsoal['pilb']; ?>
				</textarea>
				<br>

				<hr><label>Plihan C.</label>
				<textarea name="pilc" class="form-control ckeditor" id="pilc" placeholder="Masukkan Disini Untuk Jawaban Baru....">
				<?php echo $soalsoal['pilc']; ?>
				</textarea>
				<br>

				<hr><label>Plihan D.</label>
				<textarea name="pild" class="form-control ckeditor" id="pild" placeholder="Masukkan Disini Untuk Jawaban Baru....">
				<?php echo $soalsoal['pild']; ?>
				</textarea>
				<br>

				<hr><label>Plihan E.</label>
				<textarea name="pile" class="form-control ckeditor" id="pile" placeholder="Masukkan Disini Untuk Jawaban Baru....">
				<?php echo $soalsoal['pile']; ?>
				</textarea>
				<br>

				Kunci Jawaban : 
				<select id="kunci" name="kunci" class="form-control">
				  <option value="A" <?php if ($soalsoal['kunci'] == "A") {echo "selected";  }else{} ?>>A</option>
				  <option value="B" <?php if ($soalsoal['kunci'] == "B") {echo "selected";  }else{} ?>>B</option>
				  <option value="C" <?php if ($soalsoal['kunci'] == "C") {echo "selected";  }else{} ?>>C</option>
				  <option value="D" <?php if ($soalsoal['kunci'] == "D") {echo "selected";  }else{} ?>>D</option>
				  <option value="E" <?php if ($soalsoal['kunci'] == "E") {echo "selected";  }else{} ?>>E</option>
				</select>
				<b id="hasil"></b>
				<br>
				<h3>
				  <button type="submit" style="padding-right: 50px;padding-left: 50px" name="ayok" class="btn btn-block btn-flat btn-lg btn-danger pull-right update"><i class="fa fa-edit"></i> UPDATE SOAL <i class="fa fa-arrow-right"></i></button>
				</h3>
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
$(document).ready(function() {
  $('#kembali').click(function() {
  	var numur = $('#numur').val();
  	if (numur == "") {
  		window.location="bankSoal.php";
  	}else{
  		window.location="quizgurutampil.php";
  	}
  });

});
</script>
</body>
</html>