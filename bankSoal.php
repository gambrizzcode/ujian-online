<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

// ini_set("display_errors","off");
if (!$_SESSION['usernameguru'] && !$_SESSION['passwordguru']) {
  header("location:index.php");
}
else{
  $user = $_SESSION['usernameguru'];
  $pass =  $_SESSION['passwordguru'];
  $enpass = md5($pass);

  $data = mysql_query("SELECT * FROM guru INNER JOIN membuat ON guru.mapel = membuat.mapel WHERE guru.username = '$user' AND guru.password = '$enpass'");
  $isi = mysql_fetch_array($data);

  $posisi = strpos($isi['mapel'],"-");
  $katagori = substr($isi['mapel'],0,$posisi);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>E-Xam | Bank Soal</title>
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
		<li class="user-menu"><a href="#"><i><?php echo $isi['nama']; ?></i></a></li>
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
		  <li>
			<a href="profilguru.php" style="font-weight:bold">
			  <i class="fa fa-user"></i>
			  <span>PROFIL</span>
			  <span class="pull-right-container">
				<i class="fa fa-angle-double-right pull-right"></i>
			  </span>
			</a>
		  </li>
		  <li class="active">
			<a href="bankSoal.php" style="font-weight:bold">
			  <i class="fa fa-bank"></i>
			  <span>BANK SOAL</span>
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
		  <h3>
			<i class="fa fa-bank"></i> Bank Soal <?php echo $katagori; ?><br><br>
			<button type="button" style="margin-left: 20px" class="btn btn-flat btn-default pull-right refresh">REFRESH <i class="fa fa-refresh"></i></button>
			<button type="button" style="margin-left: 20px" class="btn btn-flat bg-black pull-right tambahBank" id="<?php echo $katagori; ?>">TAMBAH BANK SOAL <i class="fa fa-plus"></i></button>
			<button type="buttin" class="btn btn-flat bg-purple pull-right kembalike"><i class="fa fa-chevron-left"></i> KEMBALI KE SOAL ANDA</button>
		  </h3>
	  </section>
	  <section class="content">
			<div class="row">
			  <div class="col-md-12">
				  	<br>
					<textarea style="border-radius: 100px" id="cari" class="form-control input-lg" placeholder="KETIK SOAL DISINI UNTUK MENCARI..."></textarea>
					<br>
					<input type="hidden" id="id_ts_tujuan" value="<?php echo $isi['id_ts']; ?>">
					<input type="hidden" id="katagori" value="<?php echo $katagori; ?>">
			  </div>
			</div>

			<div class="row">
				<div class="col-md-12" id="ketCari">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs bg-info">
							<li class="active" style="width: 49%">
								<a href="#tab_pane1" data-toggle="tab"><h4><b>Soal Tayang</b></h4></a>
							</li>
							<li style="width: 49%">
								<a href="#tab_pane2" data-toggle="tab"><h4><b>Soal Tidak Tayang</b></h4></a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_pane1">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs bg-danger">
									<?php
									//terpakai									
									$queryBab = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel like '$katagori%' GROUP BY soal.bab");
									while ($tab = mysql_fetch_array($queryBab)) {
									?>
										<li>
											<a href="#tab_isi<?php echo $tab['bab']; ?>" data-toggle="tab">
												<b><?php echo $tab['bab']; ?></b>
												<a class="dropdown-toggle" data-toggle="dropdown">
													Opsi <span class="caret"></span>
												</a>
												<ul class="dropdown-menu">
													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modalBab<?php echo $tab['bab']; ?>"><i class="fa fa-trash"></i> HAPUS</button>
													</a></li>

													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm editBab" id="<?php echo $tab['bab']; ?>" name="<?php echo $isi['id_ts']; ?>"><i class="fa fa-edit"></i> EDIT</button>
													</a></li>
												</ul>
											</a>
										</li>
										
										<div class="modal modal-danger fade" id="modalBab<?php echo $tab['bab']; ?>" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h3>Yakin Hapus Bab <b><i><?php echo $tab['bab']; ?></i></b> Dan Seluruh Soal - Soal Didalamnya ???</h3>
													</div>
													<div class="modal-body">
														<button type="button" class="btn btn-success btn-block btn-lg btn-flat hapusBab" id="<?php echo $tab['bab']; ?>" name="<?php echo $isi['id_ts']; ?>"><i class="fa fa-trash"></i> HAPUS!!!</button>
														<hr>
														<div id="hasilHapusBab"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modalEditBab" role="dialog" tabindex="-1" aria-hidden="true"></div>

									<?php } ?>
								</ul>
								<div class="tab-content">
									<?php
									//terpakai
									$queryBab1 = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel like '$katagori%' GROUP BY soal.bab");
									while ($tab1 = mysql_fetch_array($queryBab1)) {
									$queryBabIsi = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel like '$katagori%' AND soal.bab = '$tab1[bab]'"); ?>
									<div class="tab-pane" id="tab_isi<?php echo $tab1['bab']; ?>">
									<?php
									while ($tabisi = mysql_fetch_array($queryBabIsi)) { ?>
										<?php //echo $tabIsi['soal']; ?>

<!-- ================================================================================================================================== -->
				<div class="box box-danger">
				<div class="box-body">
				  <h2>
				  <button type="button" class="btn btn-flat bg-navy tambahkan" name="<?php echo $tabisi[1]; ?>" id="<?php echo $tabisi[0]; ?>"><i class="fa fa-chevron-left"></i> &nbsp; TAMBAHKAN KE SOAL ANDA &nbsp; <i class="fa fa-refresh" id="ikhon"></i></button> 
				  &nbsp; 
				  <div id="ketTambahkan" style="display: none"></div>
				  <button type="button" class="btn btn-flat bg-orange edit" id="<?php echo $tabisi[0]; ?>"><i class="fa fa-edit"></i> EDIT SOAL</button>
				  &nbsp; 
				  <button type="button" class="btn btn-flat bg-maroon" data-toggle="modal" data-target="#modal<?php echo $tabisi[0]; ?>">
					<i class="fa fa-trash"></i> HAPUS SOAL
				  </button>
				  <div class="modal fade" id="modal<?php echo $tabisi[0]; ?>" role="dialog">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h3>YAKIN HAPUS SOAL INI ??</h3>
						</div>
						<div class="modal-body">
						  <center>
							<button type="button" class="btn btn-flat btn-danger btn-lg hapus" id="<?php echo $tabisi[0]; ?>"><i class="fa fa-trash"></i> HAPUS SOAL</button> 
							&nbsp;
							<button type="button" class="btn btn-flat btn-default btn-lg" data-dismiss="modal">
							  <i class="fa fa-close"></i> BATAL
							</button>
							<div id="ketHapus" style="display: none"></div>
						  </center>
						</div>
					  </div>
					</div>
				  </div>
				  </h2><hr>
				  <?php echo $tabisi['soal']; ?>
				  <br>
				  <?php
				  if ($tabisi['gambar'] != "" ) { ?>

				  <img src="images/<?php echo $tabisi['gambar']; ?>" width="50%">

				  <?php }else{}
				  if ($tabisi['audio'] != "") { ?>

				  <audio src="audio/<?php echo $tabisi['audio']; ?>" autobuffer controls></audio>

				  <?php } ?>
				  <hr>
				  <table>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>A. </b></h4></td>
						<td><?php echo $tabisi['pila']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>B. </b></h4></td>
						<td><?php echo $tabisi['pilb']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>C. </b></h4></td>
						<td><?php echo $tabisi['pilc']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>D. </b></h4></td>
						<td><?php echo $tabisi['pild']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>E. </b></h4></td>
						<td><?php echo $tabisi['pile']; ?></td>
					  </tr>
				  </table>

				  <h4><b>Kunci Jawaban : <?php echo $isi['kunci']; ?></b></h4>
				</div>
			  </div>
<!-- ================================================================================================================================== -->
									<?php
									} ?>
									</div>
									<?php
									}
									?>
								</div>
							</div>
							</div>
							<div class="tab-pane" id="tab_pane2">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs bg-warning">
									<?php
									//tidak terpakai
									$queryBa = mysql_query("SELECT * FROM soal WHERE id_ts = '$katagori' GROUP BY bab");
									while ($ta = mysql_fetch_array($queryBa)) {
									?>
										<li>
											<a href="#tab_is<?php echo $ta['bab']; ?>" title="<?php echo $ta['bab']; ?>" data-toggle="tab">
											<b><?php echo $ta['bab']; ?></b>
											<a class="dropdown-toggle" data-toggle="dropdown">
													Opsi <span class="caret"></span>
												</a>
												<ul class="dropdown-menu">
													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modalTidakTerpakaiBab<?php echo $ta['bab']; ?>"><i class="fa fa-trash"></i> HAPUS</button>
													</a></li>

													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm editBabu" id="<?php echo $ta['bab']; ?>" name="<?php echo $katagori; ?>"><i class="fa fa-edit"></i> EDIT</button>
													</a></li>
												</ul>
											</a>
										</li>
										
										<div class="modal modal-danger fade" id="modalTidakTerpakaiBab<?php echo $ta['bab']; ?>" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h3>Yakin Hapus Bab <b><i><?php echo $ta['bab']; ?></i></b> Dan Seluruh Soal - Soal Didalamnya ???</h3>
													</div>
													<div class="modal-body">
														<button type="button" class="btn btn-success btn-block btn-lg btn-flat hapusBabu" id="<?php echo $ta['bab']; ?>" name="<?php echo $katagori; ?>"><i class="fa fa-trash"></i> HAPUS!!!</button>
														<hr>
														<div id="hasilHapusBabu"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modalEditBabu" role="dialog" tabindex="-1" aria-hidden="true"></div>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<?php
									//tidak terpakai
									$queryBab2 = mysql_query("SELECT * FROM soal WHERE id_ts = '$katagori' GROUP BY bab");
									while ($tab2 = mysql_fetch_array($queryBab2)) {
									$queryBabIs = mysql_query("SELECT * FROM soal WHERE id_ts = '$katagori' AND bab = '$tab2[bab]'"); ?>
									<div class="tab-pane" id="tab_is<?php echo $tab2['bab']; ?>">
									<?php
									while ($tabis = mysql_fetch_array($queryBabIs)) { ?>
										<?php //echo $tabIs['soal']; ?>
<!-- ================================================================================================================================== -->
			  <div class="box box-danger">
				<div class="box-body">
				  <h2>
				  <button type="button" class="btn btn-flat bg-navy tambahkan" name="<?php echo $tabis[1]; ?>" id="<?php echo $tabis[0]; ?>"><i class="fa fa-chevron-left"></i> &nbsp; TAMBAHKAN KE SOAL ANDA &nbsp; <i class="fa fa-refresh" id="ikhon"></i></button> 
				  &nbsp; 
				  <div id="ketTambahkan" style="display: none"></div>
				  <button type="button" class="btn btn-flat bg-orange edit" id="<?php echo $tabis[0]; ?>"><i class="fa fa-edit"></i> EDIT SOAL</button>
				  &nbsp; 
				  <button type="button" class="btn btn-flat bg-maroon" data-toggle="modal" data-target="#modal<?php echo $tabis[0]; ?>">
					<i class="fa fa-trash"></i> HAPUS SOAL
				  </button>
				  <div class="modal fade" id="modal<?php echo $tabis[0]; ?>" role="dialog">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h3>YAKIN HAPUS SOAL INI ??</h3>
						</div>
						<div class="modal-body">
						  <center>
							<button type="button" class="btn btn-flat btn-danger btn-lg hapus" id="<?php echo $tabis[0]; ?>"><i class="fa fa-trash"></i> HAPUS SOAL</button> 
							&nbsp;
							<button type="button" class="btn btn-flat btn-default btn-lg" data-dismiss="modal">
							  <i class="fa fa-close"></i> BATAL
							</button>
							<div id="ketHapus" style="display: none"></div>
						  </center>
						</div>
					  </div>
					</div>
				  </div>
				  </h2><hr>
				  <?php echo $tabis['soal']; ?>
				  <br>
				  <?php
				  if ($tabis['gambar'] != "" ) { ?>

				  <img src="images/<?php echo $tabis['gambar']; ?>" width="50%">

				  <?php }else{}
				  if ($tabis['audio'] != "") { ?>

				  <audio src="audio/<?php echo $tabis['audio']; ?>" autobuffer controls></audio>

				  <?php } ?>
				  <hr>
				  <table>
					<tbody>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>A. </b></h4></td>
						<td><?php echo $tabis['pila']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>B. </b></h4></td>
						<td><?php echo $tabis['pilb']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>C. </b></h4></td>
						<td><?php echo $tabis['pilc']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>D. </b></h4></td>
						<td><?php echo $tabis['pild']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>E. </b></h4></td>
						<td><?php echo $tabis['pile']; ?></td>
					  </tr>
					</tbody>
				  </table>

				  <h4><b>Kunci Jawaban : <?php echo $tabis['kunci']; ?></b></h4>
				</div>
			  </div>			
<!-- ================================================================================================================================== -->
									<?php
									} ?>
									</div>
									<?php
									}
									?>
								</div>
							</div>
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
  // $('#cari').focus();
  $('#cari').keyup(function() {
	var soal = $(this).val();
	var katagori = $('#katagori').val();//mapel
	// if (soal == "") {}else{
		$.ajax({
			url: 'cariBankSoal.php',
			type: 'GET',
			data: "soal="+soal+"&katagori="+katagori,
			success:function(cari){
				$('#ketCari').html(cari);
			}
		});
	// }
  });

  $('.tambahBank').click(function() {
	var id_ts_palsu = $(this).attr('id');
	window.location="quizisi.php?id_ts="+id_ts_palsu;
  });

  $('.tambahkan').click(function() {

  	// jika asal = tujuan -> alert
  	// jika asal punya guru lain -> copy
  	// jika tidak terpakai -> ubah id_ts

	var kd_soal      = $(this).attr('id');
	var id_ts_asal   = $(this).attr('name');//tek.e soal sng kate di transfer
	var id_ts_tujuan = $('#id_ts_tujuan').val();//tek guru iki
	var katagori     = $('#katagori').val();//mapel

	if (id_ts_asal == id_ts_tujuan) {
		alert("SOAL INI TELAH ADA DI MAPEL UJIAN ANDA");
	}else{
		$.ajax({
			url: 'tambahkan.php',
			type: 'GET',
			data: "kd_soal="+kd_soal+"&asal="+id_ts_asal+"&tujuan="+id_ts_tujuan+"&katagori="+katagori,
			success:function(tambahkan){
				$('#ketTambahkan').html(tambahkan);
				// alert(tambahkan);
				alert('SOAL BERHASIL DITAMBAHKAN.. !!');
				window.location="quizgurutampil.php";
			}
		});
	}

  });

  $('.edit').click(function() {
	var kd_soal = $(this).attr('id');
	window.location="quizedit.php?id_soal="+kd_soal+"&no=";
  });

  $('.hapus').click(function() {
	var kd_soal = $(this).attr('id');
	$.ajax({
	  url: 'hapusSoal.php',
	  type: 'GET',
	  data: "kd_soal="+kd_soal,
	  success:function(hapus){
		$('#ketHapus').html(hapus);
		window.location="bankSoal.php";
	  }
	});
  });

  $('.refresh').click(function() {
  	window.location="bankSoal.php";
  });

  $('.kembalike').click(function() {
  	window.location="quizgurutampil.php";
  });

  $('.hapusBab').click(function() {
  	var bab = $(this).attr('id');
  	var id_ts = $(this).attr('name');
  	$.ajax({
  		url: 'hapusBab.php',
  		type: 'GET',
  		data: {
  			bab : bab,
  			id_ts : id_ts
  		},
  		success:function(hapusBab){
  			$('#hasilHapusBab').html(hapusBab);
  			window.location="bankSoal.php";
  		}
  	});
  });

  $('.hapusBabu').click(function() {
  	var bab = $(this).attr('id');
  	var id_ts = $(this).attr('name');
  	$.ajax({
  		url: 'hapusBab.php',
  		type: 'GET',
  		data: {
  			bab : bab,
  			id_ts : id_ts
  		},
  		success:function(hapusBab){
  			$('#hasilHapusBabu').html(hapusBab);
  			window.location="bankSoal.php";
  		}
  	});
  });

  $('.editBab').click(function() {
  	var bab = $(this).attr('id');
  	var id_ts = $(this).attr('name');
  	$.ajax({
  		url: 'modalBab.php',
  		type: 'GET',
  		data: {
  			bab : bab,
  			id_ts : id_ts
  		},
  		success:function(editBab){
  			$('#modalEditBab').html(editBab);
  			$('#modalEditBab').modal('show',{backdrop:'true'});

  			$('.TombolUpdateBab').click(function() {
				var bab     = $('#newbab').val()
				var babLama = $(this).attr('name');
				var id_ts   = $(this).attr('id');
  				$.ajax({
  					url: 'updateBab.php',
  					type: 'GET',
  					data: {
			  			bab : bab,
			  			babLama : babLama,
			  			id_ts : id_ts
			  		},
			  		success:function(updateBab){
			  			$('#hasilUpdateBab').html(updateBab);
			  			window.location="bankSoal.php";
			  		}
  				});
  			});
  		}
  	});
  });

 $('.editBabu').click(function() {
  	var bab = $(this).attr('id');
  	var id_ts = $(this).attr('name');
  	$.ajax({
  		url: 'modalBab.php',
  		type: 'GET',
  		data: {
  			bab : bab,
  			id_ts : id_ts
  		},
  		success:function(editBab){
  			$('#modalEditBabu').html(editBab);
  			$('#modalEditBabu').modal('show',{backdrop:'true'});

  			$('.TombolUpdateBab').click(function() {
				var bab     = $('#newbab').val()
				var babLama = $(this).attr('name');
				var id_ts   = $(this).attr('id');
  				$.ajax({
  					url: 'updateBab.php',
  					type: 'GET',
  					data: {
			  			bab : bab,
			  			babLama : babLama,
			  			id_ts : id_ts
			  		},
			  		success:function(updateBab){
			  			$('#hasilUpdateBab').html(updateBab);
			  			window.location="bankSoal.php";
			  		}
  				});
  			});
  		}
  	});
  }); 

});
</script>
</body>
</html>