<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['usernameguru'] && !$_SESSION['passwordguru']) {
  header("location:guru.php");
}
else{
  if (strtoupper($_SESSION['usernameguru']) == "ADMIN") {header("location:admin.php");}else{}
    
  $user = $_SESSION['usernameguru'];
  $pass =  $_SESSION['passwordguru'];
  $enpass = md5($pass);

  $data = mysql_query("SELECT * FROM guru WHERE username = '$user' AND password = '$enpass'");
  $isi = mysql_fetch_array($data);

  $id_membuat = $isi[0]."-".$isi['mapel'];

  $ehem = mysql_num_rows(mysql_query("SELECT * FROM membuat WHERE mapel = '$isi[mapel]'"));

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
	<title>E-Xam | Ujian</title>
  <link rel="icon" href="images/exam.png">
	<link rel="stylesheet" type="text/css" href="hover/hover.css">
	<link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.css">
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
                <?php
                  $ambil = mysql_query("SELECT * FROM membuat ORDER BY id_ts DESC");
                  $ts = mysql_fetch_array($ambil);
                ?>
    	<section class="content">
    		<div class="row">
        <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="#tab_1" data-toggle="tab"><h4><b>Soal yang telah anda buat</b></h4></a>
            </li>
            <li>
              <a href="#tab_2" data-toggle="tab"><h4><b>Daftar Nilai Siswa</b></h4></a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <input type="hidden" id="id_ts" name="id_ts" value="<?php echo $id_membuat; ?>">
              <input type="hidden" id="mapel" name="mapel" value="<?php echo $isi[4]; ?>">
              <input type="hidden" id="katagori" value="<?php echo $katagori; ?>">
                  <h5>
            <?php
              $lihat = mysql_query("SELECT * FROM membuat WHERE mapel = '$isi[4]'");
              $mun = mysql_fetch_array($lihat);
              $muncul = mysql_num_rows($lihat);
              if ($muncul == 0) {
                echo "<h4>Anda Belum Membuat Soal.</h4>";
                echo "<button class='btn btn-success btn-flat btn-lg' id='buat' data-toggle='modal' data-target='#myModal'>BUAT SOAL <i class='fa fa-pencil'></i></button>";
              }
              else{
                echo "<h4>Anda Sudah Membuat Soal.</h4>";
                echo "<button class='btn btn-info btn-flat btn-lg' id='lihat'>LIHAT SOAL <i class='fa fa-file-text'></i></button>"; ?>
                <button type="button" style="margin-right: 20px;margin-left: 20px" class="btn btn-flat btn-danger btn-lg" data-toggle="modal" data-target="#modalHuapus">HAPUS <i class="fa fa-trash"></i></button>

                <div class="modal fade" id="modalHuapus" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>YAKIN HAPUS SOAL ???</h3>
                      </div>
                      <div class="modal-body">
                        <h4>
                          Lebih Baik Anda <b>Ekspor</b> Terlebih Dahulu Soal Ini Sebelum Dihapus<p></p>
                          Atau Jika Anda Sudah <b>Ekspor</b> Bisa Langsung Hapus.
                        </h4><hr>
                          <button type="button" id="hapus" name="<?php echo $mun[0]; ?>" class="btn btn-flat btn-danger btn-lg btn-block">HAPUS !!! <i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <br><hr>
                <table>
                  <tr>
                    <td><h4>Kode Mapel : </h4></td>
                    <td><h4><b><?php echo $mun[1]; ?></b></h4></td>
                  </tr>
                  <tr>
                    <td><h4>Durasi Pengerjaan Soal : </h4></td>
                    <td><h4><b><?php echo $mun[2]; ?> Menit</b></h4></td>
                  </tr>
                  <tr>
                    <td><h4>Jumlah Soal Tayang : </h4></td>
                    <td><h4><b><?php echo $mun[3]; ?> Dari <?php
                    echo mysql_num_rows(mysql_query("SELECT * FROM soal WHERE id_ts = '$id_membuat'"));
                    ?> Soal</b></h4></td>
                  </tr>
                  <tr>
                    <td><h4>Jadwal Penayangan Soal : </h4></td>
                    <td><h4><b><?php echo $mun[4]; ?></b></h4></td>
                  </tr>
                </table><hr>
                <button type="button" data-toggle="modal" data-target="#modalUbah" class="btn btn-lg bg-navy btn-flat"><i class="fa fa-edit"></i> UBAH</button>
                <div class="modal fade" id="modalUbah" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>Setting Soal <i class="fa fa-gears"></i></h3>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" id="id_ts_baru" value="<?php echo $mun[0]; ?>">
                        <h4>Kode Mapel : <b><?php echo $mun[1]; ?></b></h4>
                        <h4>Durasi Pengerjaan Soal : </h4>
                        <select class="form-control" id="durasi_baru">
                          <option <?php if($mun[2] == "30"){echo "selected";} ?> value="30">30 MENIT</option>
                          <option <?php if($mun[2] == "60"){echo "selected";} ?> value="60">60 MENIT</option>
                          <option <?php if($mun[2] == "90"){echo "selected";} ?> value="90">90 MENIT</option>
                          <option <?php if($mun[2] == "120"){echo "selected";} ?> value="120">120 MENIT</option>
                        </select>
                        <h4>Jumlah Soal Tayang </h4>
                        <select class="form-control" id="exp_baru">
                          <?php
                          $tersedia = mysql_num_rows(mysql_query("SELECT * FROM soal WHERE id_ts = '$id_membuat'"));
                          for ($i=0; $i <= $tersedia; $i++) { ?>
                            <option <?php if($mun[3] == $i){echo "selected";} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php } ?>
                        </select>
                        <h4>Jadwal Penayangan </h4>
                        <input type="date" class="form-control" id="jadwal_baru" value="<?php echo $mun[4]; ?>">
                        <hr>
                        <button type="button" class="btn btn-block btn-flat btn-primary" id="ubah"><b>--- GO ---</b></button>
                        <div id="hasil_baru" style="display: none"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              }
            ?>
                  </h5>
            </div>
            <div class="tab-pane" id="tab_2">
            <div class="box-header">
              <h4>
                <b class="pull-right" style="margin-left: 15px">
                  <button type="button" id="ekspor" class="btn btn-flat btn-success" style="padding-left: 50px;padding-right: 50px">
                    <i class="fa fa-file-excel-o"></i>
                  </button>
                </b>
                <b class="pull-right" style="margin-left: 15px;">
                  <button type="button" id="print" class="btn btn-flat btn-default" style="padding-left: 50px;padding-right: 50px">
                    <i class="fa fa-print"></i>
                  </button>
                </b>
                <b class="pull-right" style="margin-left: 15px;">
                  <button type="button" id="cek" class="btn btn-flat btn-primary" style="padding-left: 50px;padding-right: 50px">
                    <i id="ikon" class="fa fa-refresh"></i>
                  </button>
                </b>
                <b class="pull-right" style="margin-left: 15px">
                <select id="kelas" class="form-control">
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
                <b class="pull-right">Kelas : </b>
              </h4>              
            </div>
            <div class="box-body" id="tampilnilai">
              
            </div>
        <input type="hidden" id="hapus_ts" name="hapus_ts" value="<?php echo $id_membuat; ?>">
        <input type="hidden" id="yoman">
            </div>
          </div>
        </div>        
        </div>
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3><i class="fa fa-edit"></i> Buat Soal</h3>
              </div>
              <div class="modal-body">
                <h4>Durasi Pengerjaan Soal / Waktu </h4>
                  <select class="form-control" id="durasi">
                    <option value="30">30 MENIT</option>
                    <option value="60">60 MENIT</option>
                    <option value="90">90 MENIT</option>
                    <option value="120">120 MENIT</option>
                  </select>
                  <input type="hidden" class="form-control" id="exp" value="0">
                  <h4>Jadwal Penayangan </h4>
                  <input type="date" class="form-control" id="jadwal">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-block btn-flat btn-primary" id="go"><b>GO</b></button>
                  <div id="hasil" style="display: none"></div>
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
  $('#kotak_topik').show(500);
  $('#kotak_soal').hide(500);
  $('#lihat').click(function() {
    window.location="quizgurutampil.php";
  });
  $('#go').click(function() {
    var id_ts = $('#id_ts').val();
    var mapel = $('#mapel').val();
    var durasi = $('#durasi').val();
    var exp = $('#exp').val();
    var batas = $('#jadwal').val();
    $.ajax({
      url: 'simpanTopikSoal.php',
      type: 'GET',
      data: "id_ts="+id_ts+"&mapel="+mapel+"&durasi="+durasi+"&exp="+exp+"&batas="+batas,
      success:function(data){
        $('#hasil').html(data);
        window.location="quizisi.php?id_ts="+id_ts;
      }
    });
  });

  $('#ubah').click(function() {
    var id_ts = $('#id_ts_baru').val();
    var durasi = $('#durasi_baru').val();
    var exp = $('#exp_baru').val();
    var batas = $('#jadwal_baru').val();
    $.ajax({
      url: 'updateTopikSoal.php',
      type: 'GET',
      data: "id_ts="+id_ts+"&durasi="+durasi+"&exp="+exp+"&batas="+batas,
      success:function(data_baru){
        $('#hasil_baru').html(data_baru);
        window.location="quizguru.php";
      }
    });
  });

  $('#hapus').click(function() {
    var id_ts = $(this).attr('name');
    var mapel = $('#mapel').val();
    var katagori = $('#katagori').val();
    $.ajax({
      url: 'hapusquiz.php',
      type: 'GET',
      data: "id_ts="+id_ts+"&katagori="+katagori+"&mapel="+mapel,
      success:function(ehem){
        $('#yoman').html(ehem);
        window.location="quizguru.php";
      }
    });
  });

  $('#cek').click(function() {
    var kelas = $('#kelas').val();
    var mapel = $('#mapel').val();
    if (kelas == "") {

    }
    else{
      $('#ikon').addClass('fa-spin');
      $.ajax({
        url: 'nilaiGuru.php',
        type: 'GET',
        data: "kelas="+kelas+"&mapel="+mapel,
        success:function(uhui){
          $('#tampilnilai').html(uhui);
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

  $('#print').click(function() {
    var mapel = $('#mapel').val();
    var kelas = $('#kelas').val();
    window.location="printNilai.php?kelas="+kelas+"&mapel="+mapel;
  });

  $('#ekspor').click(function() {
    var mapel = $('#mapel').val();
    var kelas = $('#kelas').val();
    window.location="eksporNilai.php?kelas="+kelas+"&mapel="+mapel;
  });
});
</script>
</body>
</html>