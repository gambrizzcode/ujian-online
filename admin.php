<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['usernameguru'] && !$_SESSION['passwordguru']) {
  header("location:guru.php");
}
else{
  $user = $_SESSION['usernameguru'];
  $pass =  $_SESSION['passwordguru'];
  $enpass = md5($pass);

  $data = mysql_query("SELECT * FROM guru WHERE username = '$user' AND password = '$enpass'");
  $isi = mysql_fetch_array($data);

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Admin</title>
    <link rel="icon" href="images/exam.png">
	<link rel="stylesheet" type="text/css" href="hover/hover.css">
	<link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/AdminLTE.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/skins/_all-skins.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css">
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
		<li class="user-menu"><a href="admin.php"><i class="fa fa-home"></i></a></li>
		<li class="user-menu"><a href="logout.php"><b>LOGOUT</b></a></li>
		</ul>
	  </div>
	</nav>
	</header>

	<aside class="main-sidebar">
	  <section class="sidebar" style="height:auto">
		<ul class="sidebar-menu">
		  <li class="treeview active">
			<a href="profilguru.php" style="font-weight:bold">
			  <i class="fa fa-home"></i>
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
		  <h3>Admin E-Xam</h3>
		</section>

	  <div class="modal fade" id="modaltambah" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h3>Tambah Mata Pelajaran Ujian <i class="fa fa-download"></i></h3>
			</div>
			<div class="modal-body">
			  <label>KODE MAPEL</label>
			  <input type="text" class="form-control" id="mapel"><br>
			  <label>NAMA MAPEL</label>
			  <input type="text" class="form-control" id="nama"><br>
			  <label>KELOMPOK</label>
			  <select id="kelompok" class="form-control">
				<option value="BISMAN">BISMAN</option>
				<option value="TEKNIK">TEKNIK</option>
				<option value="SEMUA">SEMUA</option>
			  </select><hr>
			  <button type="button" id="simpan" class="btn btn-flat btn-primary pull-right"><i class="fa fa-save"></i> SIMPAN</button><br><br>
			  <label id="hasil"></label>
			</div>
		  </div>
		</div>
	  </div>

	  <div class="modal fade" id="modaltambahkelas" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h3>Tambah Kelas   <i class="fa fa-download"></i></h3>
			</div>
			<div class="modal-body">
			  <label>KELAS</label>
			  <input type="text" class="form-control" id="isi_kelas"><br>
			  <label>JURUSAN</label>
			  <input type="text" class="form-control" id="isi_jurusan"><br>
			  <label>KELOMPOK</label>
			  <select id="isi_kelompok" class="form-control">
				<option value="BISMAN">BISMAN</option>
				<option value="TEKNIK">TEKNIK</option>
			  </select><hr>
			  <button type="button" id="simpankelas" class="btn btn-flat btn-primary pull-right"><i class="fa fa-save"></i> SIMPAN</button><br><br>
			  <label id="isi_hasil"></label>
			</div>
		  </div>
		</div>
	  </div>

		<section class="content">
			<div class="row">
		  <div class="col-md-12">
		  <div class="nav-tabs-custom">
			<ul class="nav nav-tabs bg-info">
			  <li class="active">
				<a href="#tab_1" data-toggle="tab"><h4><b>Mata Pelajaran</b></h4></a>
			  </li>
			  <li>
				<a href="#tab_2" data-toggle="tab"><h4><b>Daftar Nilai Siswa</b></h4></a>
			  </li>
			  <li>
				<a href="#tab_3" data-toggle="tab"><h4><b>Kelas</b></h4></a>
			  </li>
			  <li>
				<a href="#tab_4" data-toggle="tab"><h4><b>Kosongkan Peserta</b></h4></a>
			  </li>
			</ul>
			<div class="tab-content">
			  <div class="tab-pane active" id="tab_1">
			  <button type="button" id="tambah" title="TAMBAH MAPEL" style="margin-bottom: 10px;padding-right: 70px;padding-left: 70px" data-toggle="modal" data-target="#modaltambah" class="btn btn-flat btn-info"><i class="fa fa-plus"></i> TAMBAH</button>
				<table class="table table-striped table-hovered table-condensed table-default" id="mata_pelajaran">
				  <thead>
				  <tr class="info">
					<th>#</th>
					<th>KODE MAPEL</th>
					<th>MAPEL</th>
					<th>GURU</th>
					<th>KELOMPOK</th>
					<th>AKSI</th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php
				  $no = 1;
				  $query = mysql_query("SELECT * FROM mapel LEFT JOIN guru ON mapel.mapel = guru.mapel");
				  while ($row = mysql_fetch_array($query)) { ?>
				  <tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $row[0]; ?></td>
					<td><?php echo $row[1]; ?></td>
					<td><?php echo $row[4]; ?></td>
					<td><?php echo $row[2]; ?></td>
					<td>
					  <button type="button" class="btn btn-xs btn-flat btn-danger" title="HAPUS MAPEL" data-toggle="modal" data-target="#modalhapus<?php echo $row[0]; ?>">
						<i class="fa fa-trash"></i>
					  </button>
					  <div class="modal fade" id="modalhapus<?php echo $row[0]; ?>" role="dialog">
						<div class="modal-dialog">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h3 align="center">ANDA YAKIN ?</h3>
							</div>
							<div class="modal-body">
							<center>
							  <button type="button" id="<?php echo $row[0]; ?>" class="hapus btn btn-flat btn-danger">
								<i class="fa fa-trash"></i> 
								HAPUS
							  </button>
							  <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">
								<i class="fa fa-close"></i> 
								BATAL
							  </button>
							</center>
							</div>
						  </div>
						</div>
					  </div><input type="hidden" id="nyok">
					   || 
					  <button type="button" id="<?php echo $row[0]; ?>" class="buka_modal_edit btn btn-xs btn-flat btn-warning" title="EDIT MAPEL">
						<i class="fa fa-edit"></i>
					  </button>
					</td>
				  </tr>
				  <?php } ?>
				  </tbody>
				</table>
				<div class="modal fade" id="modaledit" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"></div>

			  </div>
			  <div class="tab-pane" id="tab_2">
			  <h4>

				<b class="pull-left">Mapel : </b>

				<b class="pull-left" style="margin-left: 15px">
				  <select id="pilihmapel" class="form-control" title="PILIH MAPEL">
					<option value=""></option>
					<?php
					$ambilmapel = mysql_query("SELECT * FROM mapel INNER JOIN membuat ON mapel.mapel = membuat.mapel");
					while ($inimapel = mysql_fetch_array($ambilmapel)) { ?>
					  <option value="<?php echo $inimapel[0]; ?>"><?php echo $inimapel[1]; ?></option>
					<?php } ?>
				  </select>
				</b>
				<b style="margin-left: 50px" class="pull-left">Kelas : </b>
				<b class="pull-left" style="margin-left: 15px">
				<select id="kelas" class="form-control" title="PILIH KELAS">
				  <option value=""></option>
				  <?php
				  $ambilkelas = mysql_query("SELECT * FROM jurusan");
				  while ($inikelas = mysql_fetch_array($ambilkelas)) {
				  ?>
				  <option value="<?php echo $inikelas[0]; ?>"><?php echo $inikelas[0]; ?></option>
				  <?php echo $inikelas[0]; ?>
				  <?php } ?>
				</select>
				</b>
				<b class="pull-left" style="margin-left: 15px">
				  <button type="button" id="cek" class="btn btn-flat btn-primary" style="padding-right: 50px;padding-left: 50px" title="PROSES">
				  <i id="ikon" class="fa fa-refresh"></i>
				  </button>
				</b>
				<b class="pull-left" style="margin-left: 15px">
				  <button type="button" class="btn btn-flat btn-default" id="print" style="padding-right: 50px;padding-left: 50px" title="PRINT">
				  <i id="okin" class="fa fa-print"></i>
				  </button>
				</b>
				<b class="pull-left" style="margin-left: 15px">
				  <button type="button" class="btn btn-flat btn-success" id="ekspor" style="padding-left: 50px;padding-right: 50px" title="EKSPOR NILAI KE EXCEL">
					<i class=" fa fa-file-excel-o"></i>
				  </button>
				</b>
			  </h4> 
			<div class="box-body" id="tampilnilai">
			  
			</div>
			  </div>              
			  <div class="tab-pane" id="tab_3">
			  <button type="button" id="tambahkelas" title="TAMBAH KELAS" style="margin-bottom: 10px;padding-right: 70px;padding-left: 70px" data-toggle="modal" data-target="#modaltambahkelas" class="btn btn-flat btn-info"><i class="fa fa-plus"></i> TAMBAH</button>
				<table id="admin_kelas" class="table table-striped table-hovered table-condensed">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>KELAS</th>
					  <th>JURUSAN</th>
					  <th>KELOMPOK</th>
					  <th>AKSI</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php
				  $no = 1;
				  $querykelas = mysql_query("SELECT * FROM jurusan");
				  while ($culkelas = mysql_fetch_array($querykelas)) { ?>
					<tr>
					  <td><?php echo $no++; ?></td>
					  <td><?php echo $culkelas[0]; ?></td>
					  <td><?php echo $culkelas[1]; ?></td>
					  <td><?php echo $culkelas[2]; ?></td>
					  <td>
						<button type="button" class="btn btn-xs btn-flat btn-danger" title="HAPUS KELAS" data-toggle="modal" data-target="#modalhapuskelas<?php echo $culkelas[0]; ?>">
						<i class="fa fa-trash"></i>
					  </button>
					  <div class="modal fade" id="modalhapuskelas<?php echo $culkelas[0]; ?>" role="dialog">
						<div class="modal-dialog">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h3 align="center">ANDA YAKIN ?</h3>
							</div>
							<div class="modal-body">
							<center>
							  <button type="button" class="hapuskelas btn btn-flat btn-danger" id="<?php echo $culkelas[0]; ?>">
								<i class="fa fa-trash"></i> 
								HAPUS
							  </button>
							  <button type="button" data-dismiss="modal" class="btn btn-flat btn-warning">
								<i class="fa fa-close"></i> 
								BATAL
							  </button>
							</center>
							</div>
						  </div>
						</div>
					  </div><input type="hidden" id="nyokman"> || 
					  <button type="button" id="<?php echo $culkelas[0]; ?>" class="buka_modal_edit_kelas btn btn-xs btn-flat btn-warning" title="EDIT KELAS">
						<i class="fa fa-edit"></i>
					  </button>
					  </td>
					</tr>
				  <?php } ?>
				  </tbody>
				</table>
				<div class="modal fade" id="modaleditkelas" role="dialog" tabindex="-1" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
			  </div>
			  <div class="tab-pane" id="tab_4">
				<h3>Hapus Semua Siswa / Peserta Ujian Untuk Memulai Ujian Yang Baru
					<button type="button" class="btn btn-flat btn-danger btn-lg" data-toggle="modal" data-target="#modalHapusSemuaSiswa"><i class="fa fa-trash"></i> HAPUS</button>
				</h3>
					<div class="modal fade" id="modalHapusSemuaSiswa" role="dialog">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h3>Yakin Hapus Semua Siswa / Peserta Ujian ?</h3>
						  </div>
						  <div class="modal-body">
							<center>
							  <button type="button" class="btn btn-lg btn-flat btn-danger" id="hapusSemua"><i class="fa fa-check"></i> YA</button> 
							  &nbsp;
							  <button type="button" class="btn btn-lg btn-flat btn-default" data-dismiss="modal"><i class="fa fa-close"></i> TIDAK</button>
							</center>
						  </div>
						</div>
					  </div>
					</div>

				<hr>
				<h3>Atau, Hapus Beberapa Saja
					<button type="button" class="btn btn-flat btn-warning btn-lg" data-toggle="modal" data-target="#modalHapusBeberapa"><i class="glyphicon glyphicon-trash"></i> HAPUS</button>
				</h3>
					<div class="modal fade" id="modalHapusBeberapa" role="dialog">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h3>Hapus Siswa / Peserta Ujian</h3>
						  </div>
						  <div class="modal-body">
							<label>NIS</label>
							<input type="text" id="nishapus" class="form-control"><br>
							<label>NO PESERTA</label>
							<input type="text" id="nopeshapus" class="form-control"><br>
							<center>
							  <button type="button" id="hapusBeberapa" class="btn btn-lg btn-flat btn-danger"><i class="fa fa-trash"></i> HAPUS</button> &nbsp;
							  <button type="button" class="btn btn-lg btn-flat btn-default" data-dismiss="modal"><i class="fa fa-close"></i> TIDAK</button>
							  <hr>
							  <div id="hasil_hapus" style="display: none"></div>
							</center>
						  </div>
						</div>
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
  <script src="datatables/jquery.dataTables.min.js"></script>
  <script src="datatables/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
  $('#simpan').click(function() {
	var mapel = $('#mapel').val();
	var nama  = $('#nama').val();
	var kelompok = $('#kelompok').val();
	$.ajax({
	  url: 'simpanMapel.php',
	  type: 'GET',
	  data: "mapel="+mapel+"&nama="+nama+"&kelompok="+kelompok,
	  success:function(data){
		$('#hasil').html(data);
		window.location="admin.php";
	  }
	});
  });

  $('#simpankelas').click(function() {
	var kelas = $('#isi_kelas').val();
	var jurusan  = $('#isi_jurusan').val();
	var kelompok = $('#isi_kelompok').val();
	$.ajax({
	  url: 'simpanKelas.php',
	  type: 'GET',
	  data: "kelas="+kelas+"&jurusan="+jurusan+"&kelompok="+kelompok,
	  success:function(dete){
		$('#hasil').html(dete);
		window.location="admin.php";
	  }
	});
  });

  $('.hapus').click(function() {
	var mapel = $(this).attr('id');
	$.ajax({
	  url: 'hapusMapel.php',
	  type: 'GET',
	  data: "mapel="+mapel,
	  success:function(berhasil){
		$('#nyok').html(berhasil);
		window.location="admin.php";
	  }
	});
  });

  $('.hapuskelas').click(function() {
	var kelas = $(this).attr('id');
	$.ajax({
	  url: 'hapusKelas.php',
	  type: 'GET',
	  data: "kelas="+kelas,
	  success:function(berhasilkah){
		$('#nyokman').html(berhasilkah);
		window.location="admin.php";
	  }
	});
  });

  $('.buka_modal_edit').click(function() {
	var mapel = $(this).attr('id');
	$.ajax({
	  url: 'modalEdit.php',
	  type: 'GET',
	  data: "mapel="+mapel,
	  success:function(data){
		$('#modaledit').html(data);
		$('#modaledit').modal('show',{backdorp:'true'});
		$('#update').click(function() {
		  var newmapel = $('#newmapel').val();
		  var newnama = $('#newnama').val();
		  var newkelompok = $('#newkelompok').val();
		  $.ajax({
			url: 'updateMapel.php',
			type: 'GET',
			data: "mapel="+newmapel+"&nama="+newnama+"&kelompok="+newkelompok,
			success:function(tingkat){
			  $('#tingkat').html(tingkat);
			  window.location="admin.php";
			}
		  });
		});
	  }
	});
  });

  $('.buka_modal_edit_kelas').click(function() {
	var kelas = $(this).attr('id');
	$.ajax({
	  url: 'modalKelas.php',
	  type: 'GET',
	  data: "kelas="+kelas,
	  success:function(doto){
		$('#modaleditkelas').html(doto);
		$('#modaleditkelas').modal('show',{backdorp:'true'});
		$('#updatekelas').click(function() {
		  var newkelas = $('#newkelas').val();
		  var newjurusan = $('#newjurusan').val();
		  var newkelompokk = $('#newkelompokk').val();
		  $.ajax({
			url: 'updateKelas.php',
			type: 'GET',
			data: "kelas="+newkelas+"&jurusan="+newjurusan+"&kelompok="+newkelompokk,
			success:function(tingkatdua){
			  $('#tingkatdua').html(tingkatdua);
			  window.location="admin.php";
			}
		  });
		});
	  }
	});
  });

  $('#cek').click(function() {
	var mapel = $('#pilihmapel').val();
	var kelas = $('#kelas').val();
	if (mapel == "" || kelas == "") {}
	  else{
		$('#ikon').addClass('fa-spin');
		$.ajax({
		  url: 'nilaiAdmin.php',
		  type: 'GET',
		  data: "kelas="+kelas+"&mapel="+mapel,
		  success:function(uye){
			$('#tampilnilai').html(uye);
			$('#ikon').removeClass('fa-spin');
			$('#daftarnilai').DataTable({
			"paging":true,
			"lengthChange":true,
			"searching":true,
			"ordering":true,
			"autoWidth":true
		  });
		  }
		});
	  }
  });

  $('#mata_pelajaran').DataTable({
	"paging":true,
	"lengthChange":true,
	"searching":true,
	"ordering":true,
	"autoWidth":true
  });

  $('#admin_kelas').DataTable({
	"paging":true,
	"lengthChange":true,
	"searching":true,
	"ordering":true,
	"autoWidth":true
  });

  $('#print').click(function() {
	var mapel = $('#pilihmapel').val();
	var kelas = $('#kelas').val();
	window.location="printNilaiAdmin.php?kelas="+kelas+"&mapel="+mapel;
  });

  $('#ekspor').click(function() {
	var mapel = $('#pilihmapel').val();
	var kelas = $('#kelas').val();
	window.location="eksporNilai.php?kelas="+kelas+"&mapel="+mapel;
  });

  $('#hapusSemua').click(function() {
	window.location="hapusSemua.php";
  });

  $('#hapusBeberapa').click(function() {
	var data_dihapus = {
		nishapus   : $('#nishapus').val(),
		nopeshapus : $('#nopeshapus').val()
	};
	$('#nishapus').val();
	$.ajax({
		url: 'hapusBeberapa.php',
		type: 'GET',
		data: data_dihapus,
		success:function(dihapus){
			$('#hasil_hapus').html(dihapus);
			window.location="admin.php";
		}
	});
  });
});
</script>
</body>
</html>