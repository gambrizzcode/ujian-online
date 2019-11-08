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

  $ambilurl = mysql_query("SELECT * FROM jawaban WHERE nis = '$isi[0]'");
  $url = mysql_fetch_array($ambilurl);
  if ($url['ket'] != "") {
    $panjang = strlen($url['ket']);
    $dapatkuki = substr($url['ket'],$panjang-4,$panjang);
    setcookie('soal',$isi[0],time()+$dapatkuki);
    header("location:".$url['ket']);
  }else{

  }

  $dete = mysql_query("SELECT * FROM siswa INNER JOIN jurusan ON siswa.kelas = jurusan.kelas WHERE siswa.username = '$user' AND siswa.password = '$enpass'");
  $ese = mysql_fetch_array($dete);//[7]

  // $hokya = mysql_query("SELECT * FROM jawaban INNER JOIN siswa ON jawaban.nis = siswa.nis INNER JOIN ")
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
	<link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.min.css">
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
          <li class="treeview">
            <a href="home.php" style="font-weight:bold;">
              <i class="fa fa-home"></i>
              <span>BERANDA</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-double-right pull-right"></i>
              </span>
            </a>
          </li>
          <li class="active">
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
    		<!-- <div class="col-md-10"> -->
        <input type="hidden" id="nis" value="<?php echo $isi[0]; ?>">
    			<div class="box box-primary">
            <div class="box-header">
              <h3><i class="fa fa-edit"></i> UJIAN</h3>
            </div>
	    			<div class="box-body">
            <h4>Pilih salah satu mata ujian yang akan anda kerjakan</h4>
            <h4>Mata Pelajaran yang tertera adalah sesuai dengan jadwal yang ditentukan</h4>
            <br>
              <?php
                $nilai = 0;
                $k3 = substr($isi[3], 2, 1);
                $k2 = substr($isi[3], 1, 1);
                if ($k3 == "I" && $k2 == "I") {
                  $kelas = "XII";
                }
                elseif($k3 != "I" && $k2 == "I") {
                  $kelas = "XI";
                }
                else{
                  $kelas = "X";
                }
                $hariini = date('Y-m-d');
                $look = mysql_query("SELECT * FROM membuat WHERE batas = '$hariini' AND mapel like '%$kelas' OR mapel like '%".$ese[9]."'");
                while ($up = mysql_fetch_array($look)) {
                $jumlahsoal = mysql_query("SELECT * FROM membuat WHERE mapel = '$up[1]'");
                $score = mysql_fetch_array($jumlahsoal);
                $cobak = mysql_query("SELECT * FROM soal INNER JOIN jawaban ON soal.kd_soal = jawaban.kd_soal WHERE jawaban.nis = '$isi[0]' AND soal.id_ts = '$up[0]'");
                $seluruh = mysql_num_rows($cobak);
                if ($seluruh == 0) { ?>
                <button type="button" style="width: 25%" class="btn btn-flat btn-info" id="<?php echo $up[1]; ?>" data-toggle="modal" data-target="#<?php echo 'id'.$up[1];?>"><?php echo $up[1]; ?></button>
                <?php
                }else{ ?>
                <button type="button" style="width: 25%" class="btn btn-flat btn-success" disabled="disabled" id="<?php echo $up[1]; ?>"><?php echo $up[1]; ?></button>
                <?php
                }
                ?>
                <?php
                $hora = mysql_num_rows(mysql_query("SELECT * FROM soal INNER JOIN jawaban ON soal.kd_soal = jawaban.kd_soal WHERE soal.kunci = jawaban.jawaban AND jawaban.nis = '$isi[0]' AND soal.id_ts = '$up[0]'"));
                // echo $score['jumlah'];
                // echo "<br>";
                // echo $seluruh;
                  if ($seluruh == 0) {
                    echo "<b style='font-size:16px'>&nbsp;&nbsp;&nbsp; Anda Belum Mengerjakan &nbsp;&nbsp;&nbsp;</b><br>";
                  }
                  else{
                    echo "<b style='font-size:16px' class='text-green'>&nbsp;&nbsp;&nbsp; Anda Sudah Mengerjakan. &nbsp;&nbsp;&nbsp;";
                    echo "<span class='label bg-green' style='font-size:16px'>NILAI : ";
                    echo $hora*(100/$score['jumlah']);
                    echo "</span></b><br>";
                  }
                ?>
                <br>

                <div class="modal fade" id="<?php echo 'id'.$up[1]; ?>" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>Baca dengan seksama dan teliti sebelum mengerjakan Ujian</h3> 
                      </div>
                      <div class="modal-body">
                        <label>1. Pastikan sumber listrik yang akan anda gunakan cukup baik</label><br>
                        <label>2. Pastikan koneksi internet yang anda miliki cukup stabil dan baik</label><br>
                        <label>3. Pilih browser yang kami rekomendasikan yaitu Chrome</label><br>
                        <label>4. Jika listrik mati hubungi langsung hubungi pengawas ujian di ruangan anda</label><br>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-lg btn-success btn-block pull-right mulai" id="<?php echo $up[1]; ?>">
                        <i class="fa fa-pencil"></i> MULAI MENGERJAKAN <i class="fa fa-refresh" id="ikhon"></i></button>
                        <div id="uhui"></div>
                      </div>
                    </div>
                  </div>
                </div>

              <?php
              }
              ?>
	    			</div>
	    		</div>
    		<!-- </div> -->
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
  $('.mulai').click(function() {
    var mapel = $(this).attr('id');
    var jumlah = $('#terakhir').val();
    var nis = $('#nis').val();
    $('#ikhon').addClass('fa-spin');
    $.ajax({
      url: 'yojawaban.php',
      type: 'GET',
      data: "mapel="+mapel+"&nis="+nis,
      success:function(uhui){
        $('#ikhon').removeClass('fa-spin');
        $('#uhui').html(uhui);
        // alert(uhui);
        var kuki = $('#kuki').val();
        window.location="soal.php?mapel="+mapel+"&ke="+0+"&kuki="+kuki;
      }
    });
  });
});
</script>
</body>
</html>