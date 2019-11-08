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

  $data = mysql_query("SELECT * FROM guru INNER JOIN membuat ON guru.mapel = membuat.mapel WHERE guru.username = '$user' AND guru.password = '$enpass'");
  $isi = mysql_fetch_array($data);

  $ehem = mysql_num_rows(mysql_query("SELECT * FROM membuat WHERE mapel = '$isi[mapel]'"));

  $posisi = strpos($isi[4],"-");
  $katagori = substr($isi[4],0,$posisi);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Soal Anda</title>
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
          <h2><i class="fa fa-edit"></i> Soal Anda</h2>

          <h3><button type="button" style="margin-left:15px" id="print" name="<?php echo $isi['id_ts']; ?>" class="btn pull-right btn-lg btn-info">PRINT <i class="fa fa-print"></i></button></h3>

          <h3><button type="button" style="margin-left: 15px" id="ekspor" name="<?php echo $isi['id_ts']; ?>" class="btn pull-right btn-lg btn-success">EKSPOR <i class="fa fa-file-excel-o"></i></button></h3>

          <h3><button type="button" style="margin-left: 15px" id="tambah" name="<?php echo $isi['id_ts']; ?>" class="btn btn-lg bg-navy pull-right">TAMBAH <i class="fa fa-plus"></i></button></h3>

          <h3><button type="button" style="margin-left: 15px" data-toggle="modal" data-target="#modalAturBab" class="btn btn-lg bg-teal pull-right">ATUR BAB <i class="fa fa-wrench"></i></button></h3>

          <h3><button type="button" style="margin-left: 15px" id="bankSoal" class="btn pull-right btn-lg bg-maroon">AMBIL DARI BANK SOAL <i class="fa fa-bank"></i></button></h3>

          <h3><button type="button" style="margin-left: 15px" id="kembali" class="btn pull-right btn-lg btn-default"><i class="fa fa-chevron-left"></i> KEMBALI</button></h3>
          <br><br>

          <div class="modal fade" id="modalAturBab" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3>Atur Komposisi Soal <i class="fa fa-wrench"></i></h3>
                </div>
                <div class="modal-body">
                <input type="hidden" id="id_ts" value="<?php echo $isi['id_ts']; ?>">
                  <table>
                  <?php
                  $uhukuhuk = mysql_query("SELECT sum(jumlah) AS total FROM bab WHERE id_ts = '$isi[id_ts]'");
                  $huacing  = mysql_fetch_array($uhukuhuk);
                  $totalbab  = $huacing['total'];//yg ada di bab
                  $totalasli = $isi['jumlah'];//yg ada di membuat

                  $queryBab = mysql_query("SELECT * FROM soal WHERE id_ts = '$isi[id_ts]' GROUP BY bab");
                  while ($isiBab = mysql_fetch_array($queryBab)) {
                    $yoBab = mysql_query("SELECT * FROM bab WHERE bab = '$isiBab[bab]'");
                    $diBab = mysql_fetch_array($yoBab);
                    $jBaru = $diBab[2];
                    ?>
                    <tr>
                      <td style="padding-right: 5px"><h4><label>BAB : </label></h4></td>
                      <td style="padding-right: 20px"><h4><label><?php echo strtoupper($isiBab['bab']); ?>, </label></h4></td>
                      <td style="padding-right: 5px"><label>tampilkan </label></td>
                      <td style="padding-right: 5px">
                        <select class="form-control jumlahSoalPerBab" id="<?php echo $isiBab['bab']; ?>" name="<?php echo $jBaru; ?>">
                          <option value=""></option>
                          <?php
                          $jumlahSoalPerBab = mysql_num_rows(mysql_query("SELECT * FROM soal WHERE id_ts = '$isi[id_ts]' AND bab = '$isiBab[bab]'"));//jml soal perbab

                          // $tot = $totalasli-$totalbab;//5-3
                          // if ($jumlahSoalPerBab <= $tot && $jumlahSoalPerBab <= $totalasli) {//4 <= 2
                          //   $max = $tot;
                          // }elseif($jumlahSoalPerBab >= $tot && $jumlahSoalPerBab <= $totalasli){//4 >= 2 && 4 <=5
                          //   $max = $jumlahSoalPerBab;
                          // }elseif($jumlahSoalPerBab >= $tot && $jumlahSoalPerBab >= $totalasli){//4 >= 2 && 4 <=5
                          //   $max = $tot;
                          // }

                          // if ($jumlahSoalPerBab <= $totalasli) {//4<=5
                          //   if ($jumlahSoalPerBab <= $totalbab) {//4<=2
                          //     $max = $jumlahSoalPerBab;
                          //   }elseif($jumlahSoalPerBab >= $totalbab && $jumlahSoalPerBab <= $totalasli){//4>=2 , 4<=5
                          //     $max = $tot;//2
                          //   }elseif($jumlahSoalPerBab <= $totalbab && $jumlahSoalPerBab <= $totalasli){//2>=4 , 4<=5
                          //     $max = $tot;//2
                          //   }
                          // }
                          // elseif($jumlahSoalPerBab <= $totalbab){
                          //     $max = 
                          // }

                          for ($i=0; $i <= $jumlahSoalPerBab; $i++) {

                          ?>
                          <option <?php if($jBaru == $i){echo "selected";} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td style="padding-right: 20px"><label>Soal</label></td>
                      <td><b id="berhasil<?php echo $isiBab['bab']; ?>"></b></td>
                    </tr>
                  <?php } ?>
                  </table>
                  <hr>
                  <button type="button" class="btn btn-primary btn-block btn-flat btn-lg okeBab">
                    <i class="fa fa-gear"></i> ATUR
                  </button>
                </div>
              </div>
            </div>
          </div>

    	</section>
    	<section class="content">
    		<div class="row">
          <div class="col-md-12">
          <?php
            $no = 1;
            $datasoal = mysql_query("SELECT * FROM soal WHERE id_ts = '$isi[id_ts]'");

            while ($soalsoal = mysql_fetch_array($datasoal)) {

            $yuhir = mysql_query("SELECT * FROM jawaban WHERE kd_soal = '$soalsoal[0]'");

            $yihur = mysql_num_rows($yuhir);//total siswa yang menjawab

            $nilaikelas = mysql_query("SELECT * FROM jawaban INNER JOIN soal ON jawaban.kd_soal = soal.kd_soal WHERE soal.kd_soal = '$soalsoal[0]' AND jawaban.jawaban = soal.kunci");

            $inilai = mysql_num_rows($nilaikelas);//benar
            $presentase = $inilai/$yihur*100;

          ?>
            <div class="box box-primary" id="kotak_topik">
              <div class="box-body">
                <h4>
                  <b>Soal No : </b><b><?php echo $no++; ?></b>
                  <b class="pull-right" style="margin-left: 25px"><input type="text" class="knob pull-right" value="<?php echo floor($presentase); ?>" data-skin="tron" data-width="80" data-height="80" data-fgColor="red" data-thickness="0.15" readonly></b>
                  <b class="pull-right"><?php echo "Bab : ".$soalsoal['bab']; ?></b>
                </h4>
                <h4><?php echo $soalsoal[2]; ?></h4>
                <?php
                if ($soalsoal['gambar'] == "") {}
                else{ ?>
                  <hr><img src="images/<?php echo $soalsoal['gambar']; ?>" style="width: 70%">
                <?php }
                $no--;
                if ($soalsoal['audio'] == "") {}
                else{ ?>
                  <hr><audio autobuffer autoloop loop controls class="col-md-12">
                    <source src="audio/<?php echo $soalsoal['audio']; ?>">
                  </audio>
                <?php
                }
                ?>

                <br><hr>
                <table>
                  <tr valign="middle">
                    <td style="padding-right: 15px"><p><b>A. </b></p></td>
                    <td><?php echo $soalsoal['pila']; ?></td>
                  </tr>
                  <tr valign="middle">
                    <td><p><b>B. </b></p></td>
                    <td><?php echo $soalsoal['pilb']; ?></td>
                  </tr>
                  <tr valign="middle">
                    <td><p><b>C. </b></p></td>
                    <td><?php echo $soalsoal['pilc']; ?></td>
                  </tr>
                  <tr valign="middle">
                    <td><p><b>D. </b></p></td>
                    <td><?php echo $soalsoal['pild']; ?></td>
                  </tr>
                  <tr valign="middle">
                    <td><p><b>E. </b></p></td>
                    <td><?php echo $soalsoal['pile']; ?></td>
                  </tr>
                </table>
                 
                <hr>
                <h4>Kunci Jawaban : <?php echo $soalsoal['kunci'] ?></h4>
                <h5 class="pull-right">
                  <button type="button" class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalHapusSoal<?php echo $soalsoal[0]; ?>">
                    <i class="fa fa-trash"></i> HAPUS SOAL
                  </button>

                  <div class="modal fade" id="modalHapusSoal<?php echo $soalsoal[0]; ?>" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h3>YAKIN HAPUS SOAL INI ???</h3>
                        </div>
                        <div class="modal-body">
                          <center>
                          <input type="hidden" id="katagori" value="<?php echo $katagori; ?>">
                          <button type="button" class="btn btn-flat btn-lg btn-danger hapus" name="<?php echo $soalsoal[0]; ?>">
                            <i class="fa fa-trash"></i> HAPUS SOAL
                          </button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          <div id="hapuso" style="display: none"></div>
                          <button type="button" class="btn btn-flat btn-lg btn-default" data-dismiss="modal">
                            BATAL
                          </button>
                          </center>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-flat btn-warning edit" no="<?php echo $no++; ?>" name="<?php echo $soalsoal[0]; ?>"><i class="fa fa-edit"></i> EDIT SOAL</button>
                </h5>
              </div>
            </div>
          <?php
            }
          ?>
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
  <script src="knob/jquery.knob.js"></script>
<script>
$(document).ready(function() {
  $('.hapus').click(function() {
    var kd_soal = $(this).attr('name');
    var katagori = $('#katagori').val();
    $.ajax({
      url: 'hapusSoalPalsu.php',
      type: 'GET',
      data: "kd_soal="+kd_soal+"&katagori="+katagori,
      success:function(hapuso){
        $('#yowes').html(hapuso);
        window.location="quizgurutampil.php";
      }
    });
  });

  $('#kembali').click(function() {
    window.location="quizguru.php";
  });
  $('.edit').click(function() {
    var halEdit = $(this).attr('name');
    var no = $(this).attr('no');
    window.location="quizedit.php?id_soal="+halEdit+"&no="+no;
  });
  $('#print').click(function() {
    var id_ts = $(this).attr('name');
    window.location="printSoal.php?id_ts="+id_ts;
  });
  $('#ekspor').click(function() {
    var id_ts = $(this).attr('name');
    window.location="eksporSoal.php?id_ts="+id_ts;
  });
  $('#tambah').click(function() {
    var id_ts = $(this).attr('name');
    window.location="quizisi.php?id_ts="+id_ts;
  });
  $('#bankSoal').click(function() {
    window.location="bankSoal.php";
  });

    $(".knob").knob({
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  
              , sa = this.startAngle   
              , sat = this.startAngle  
              , ea                     
              , eat = sat + a          
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });

    $('.jumlahSoalPerBab').click(function() {
      var lama   = $(this).attr('name');
      var id_ts  = $('#id_ts').val();
      var bab    = $(this).attr('id');
      var jumlah = $(this).val();
      if (jumlah == "") {}else if(lama == jumlah){
        
      }else{
        $.ajax({
          url: 'aturBab.php',
          type: 'GET',
          data: {
            id_ts  : id_ts,
            bab    : bab,
            jumlah : jumlah
          },
          success:function(jumlahBab){
            $('#berhasil'+bab).html(jumlahBab);
          }
        });
      }
    });

    $('.okeBab').click(function() {
      window.location="quizgurutampil.php";
    });

});
</script>
</body>
</html>