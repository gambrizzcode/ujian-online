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

  if ($_COOKIE['soal'] == "" || !$_COOKIE['soal']) {
    $krj->hapusKet($isi[0]);
    header("location:quiz.php");
  }else{

  }

  $dete = mysql_query("SELECT * FROM siswa INNER JOIN jurusan ON siswa.kelas = jurusan.kelas WHERE username = '$user' AND password = '$enpass'");
  $ese = mysql_fetch_array($dete);//[7]

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Soal</title>
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
<input type="hidden" id="siswa" value="<?php echo $isi[0]; ?>">
<div class="wrapper">
	<header class="main-header">
    <a href="#" class="logo">
      <span class="logo-mini">
        <b>E</b>-X
      </span>
      <span class="logo-lg">
        <b>E</b>-Xam
      </span>
    </a>

    <nav class="navbar navbar-static-top">
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav pull-right">
        <li class="user-menu"><a href="#"><i><?php echo $isi['nama']; ?></i></a></li>
        </ul>
      </div>
    </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar" style="height:auto">
        <ul class="sidebar-menu">
        </ul>
      </section>
    </aside>
    <input type="hidden" id="nis" value="<?php echo $isi[0]; ?>">
    <div class="content-wrapper">
    	<section class="content-header">
      <?php $kuki = $_REQUEST['kuki']; ?>
      <input type="hidden" id="kuki" class="cuki" value="<?php echo $kuki; ?>">
        <?php
        $ambillah = mysql_query("SELECT * FROM membuat INNER JOIN mapel ON membuat.mapel = mapel.mapel WHERE membuat.mapel = '$_REQUEST[mapel]'");
        $iko = mysql_fetch_array($ambillah);
        ?>
          <h2><i class="fa fa-edit"></i> UJIAN <?php echo $iko['nama']; ?></h2>
          <input type="hidden" value="<?php echo $_REQUEST['mapel']; ?>" id="mapel">
          <input type="hidden" value="<?php echo $_REQUEST['ke']; ?>" id="ke">
    	</section>
      <!-- <div id="ehem"></div> -->
    	<section class="content">
    		<div class="row">
        <div class="col-md-8">
        <?php
          $no = 1;
          $jupuk = mysql_query("SELECT * FROM membuat WHERE mapel = '$_REQUEST[mapel]'");
          $iku = mysql_fetch_array($jupuk);

          $limBab = 0;

          $limSoal = $_REQUEST["ke"];
          $tampil = $iku['jumlah'];
          $tayang = $iku['jumlah']-1;
          if ($tayang < $limSoal) {
            $limSoal = $iku['jumlah']-1;
          }

          ?>
          <!-- BEGIN SOAL -->
          <?php
          $ambilsoal = mysql_query("SELECT * FROM soal INNER JOIN jawaban ON soal.kd_soal = jawaban.kd_soal WHERE jawaban.nis = '$isi[0]' AND soal.id_ts = '$iku[0]' ORDER BY soal.audio DESC, RAND('$isi[0]') limit $limSoal,1");//tambah parameter
          while ($soal = mysql_fetch_array($ambilsoal)) {
          ?>
          <input type="hidden" id="id_ts" value="<?php echo $iku[0]; ?>">
          <input type="hidden" id="waktu" value="<?php echo $iku[2]; ?>">
          <div class="box box-primary">
            <div class="box-header">
              <h4>Soal No : <b id="no"><?php echo $no+$limSoal; ?></b></h4>
            </div>
            <div class="box-body">
              <input type="hidden" id="id_soal" value="<?php echo $soal[0]; ?>">
              <?php
              $keren = mysql_query("SELECT * FROM jawaban WHERE nis = '$isi[0]' AND kd_soal = '$soal[0]'");
              while ($banget = mysql_fetch_array($keren)) {
                echo "<input type='hidden' id='sudah' name='".$banget['kd_soal']."' value='".$banget['jawaban']."'>";
              }
              ?>
                <div style="background-color: white;border:none; width: 100%;padding: 5px;"><?php echo $soal[2]; ?></div> 
              <br>
              <?php
              if ($soal['gambar'] == "") {}
              else{
                echo "<img style='width:50%' src='images/".$soal['gambar']."'><hr>";
              }
              if ($soal['audio'] == "") {}else{ ?>
                <audio autobuffer controls class="col-md-12">
                  <source src="audio/<?php echo $soal['audio']; ?>">
                </audio>
                <?php
              }
              ?>
              <br>
              <table>
                <tr>
                  <td align="right"><input type="button" class="iCheck btn btn-default btn-flat A jawaban" id="A" name="<?php echo $soal[0]; ?>" value="A"></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td class="menjawab" name="A" width="100%">
                  <div class="AA menjawab" name="A" style="background-color: white;border:none;width: 100%;min-height: 50px;padding: 5px;cursor:pointer;"><?php echo $soal['pila']; ?></div>
                  </td>
                </tr>
                <tr><td>
                  <br>
                </td></tr>
                <tr>
                  <td align="right"><input type="button" class="iCheck btn btn-default btn-flat B jawaban" id="B" name="<?php echo $soal[0]; ?>" value="B"></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td class="menjawab" name="B" width="100%">
                  <div class="BB menjawab" name="B" style="background-color: white;border:none;width: 100%;min-height: 50px;padding: 5px;cursor:pointer;"><?php echo $soal['pilb']; ?></div>
                  </td>
                </tr>
                <tr><td>
                  <br>
                </td></tr>
                <tr>
                  <td align="right"><input type="button" class="iCheck btn btn-default btn-flat C jawaban" id="C" name="<?php echo $soal[0]; ?>" value="C"></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td class="menjawab" name="C" width="100%">
                  <div class="CC menjawab" name="C" style="background-color: white;border:none;width: 100%;min-height: 50px;padding: 5px;cursor:pointer;"><?php echo $soal['pilc']; ?></div>
                  </td>
                </tr>
                <tr><td>
                  <br>
                </td></tr>
                <tr>
                  <td align="right"><input type="button" class="iCheck btn btn-default btn-flat D jawaban" id="D" name="<?php echo $soal[0]; ?>" value="D"></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td class="menjawab" name="D" width="100%">
                  <div class="DD menjawab" name="D" style="background-color: white;border:none;width: 100%;min-height: 50px;padding: 5px;cursor:pointer;"><?php echo $soal['pild']; ?></div>
                  </td>
                </tr>
                <tr><td>
                  <br>
                </td></tr>
                <tr>
                  <td align="right"><input type="button" class="iCheck btn btn-default btn-flat E jawaban" id="E" name="<?php echo $soal[0]; ?>" value="E"></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td class="menjawab" name="E" width="100%">
                  <div class="EE menjawab" name="E" style="background-color: white;border:none;width: 100%;min-height: 50px;padding: 5px;cursor:pointer;"><?php echo $soal['pile']; ?></div>
                  </td>
                </tr>
              </table>

              <br><br><br><br><br>
              <button type="button" id="mundur" class="btn btn-warning btn-lg btn-flat pull-left"><i class="fa fa-chevron-left"></i> MUNDUR <i class="fa fa-minus-square"></i></button>
              <button type="button" id="lanjut" class="btn btn-danger btn-lg btn-flat pull-right"><i class="fa fa-plus-square"></i> LANJUT <i class="fa fa-chevron-right"></i></button>
            </div>
          </div>
          <?php } //} ?>
          <!-- END SOAL -->
          
        </div>
        <input type="hidden" id="jawaban">
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-body">
              <center>
                <h4>SISA WAKTU <i class="fa fa-hourglass-2"></i></h4>
              <h1><div id="timer"></div></h1>
              </center>
              <?php
              $versoal = mysql_query("SELECT * FROM soal WHERE id_ts = '$iku[0]' AND audio <> ''");
              $cek     = mysql_num_rows($versoal);
              if ($cek == 0) { ?>
              <div class="well">
                    <?php
                    $jum = 1;
                    $jumlahsoal = mysql_query("SELECT * FROM soal INNER JOIN jawaban ON soal.kd_soal = jawaban.kd_soal WHERE soal.id_ts = '$iku[0]' AND jawaban.nis = '$isi[0]' ORDER BY RAND('$isi[0]')");
                    while ($jumlah = mysql_fetch_array($jumlahsoal)) { ?>
                    <button type="button" class="btn btn-sm jum <?php if($jumlah['jawaban'] == ''){echo 'btn-info';}else{echo 'btn-success';} ?>" id="<?php echo $jumlah[0]; ?>" style="width: 40px;margin-top: 5px"><?php echo $jum++; ?></button>
                    <?php } ?>
              </div>
              <?php }else{ ?>
              <div class="box box-danger">
                    <div class="box-header">
                      <label>Soal Audio</label>
                    </div>
                    <div class="box-body">
                      <?php
                    $jum2 = 1;
                    $jumlahsoal2 = mysql_query("SELECT * FROM soal INNER JOIN jawaban ON soal.kd_soal = jawaban.kd_soal WHERE soal.id_ts = '$iku[0]' AND jawaban.nis = '$isi[0]' AND soal.audio <> ''");
                    while ($jumlah2 = mysql_fetch_array($jumlahsoal2)) { ?>
                    <button type="button" class="btn btn-sm jum <?php if($jumlah2['jawaban'] == ''){echo 'btn-info';}else{echo 'btn-success';} ?>" id="<?php echo $jumlah2[0]; ?>" style="width: 40px;margin-top: 5px"><?php echo $jum2++; ?></button>
                    <?php } ?>
                    </div>
                    
                  </div>
                  <div class="box box-warning">
                    <div class="box-header">
                      <label>Soal Biasa</label>
                    </div>
                    <div class="box-body">
                      <?php
                    $jumlahsoal3 = mysql_query("SELECT * FROM soal INNER JOIN jawaban ON soal.kd_soal = jawaban.kd_soal WHERE soal.id_ts = '$iku[0]' AND jawaban.nis = '$isi[0]' AND soal.audio = ''");
                    while ($jumlah3 = mysql_fetch_array($jumlahsoal3)) { ?>
                    <button type="button" class="btn btn-sm jum <?php if($jumlah3['jawaban'] == ''){echo 'btn-info';}else{echo 'btn-success';} ?>" id="<?php echo $jumlah3[0]; ?>" style="width: 40px;margin-top: 5px"><?php echo $jum2++; ?></button>
                    <?php } ?>
                    </div>
                  </div>
              <?php } ?>

              <p>
                <center><button type="button" data-toggle="modal" data-target="#modalKumpul" class="btn bg-navy btn-lg btn-flat">KUMPULKAN <i class="fa fa-thumbs-o-up"></i></button></center>
              </p>
              <input type="hidden" value="<?php echo $iku['jumlah']; ?>" id="terakhir">
              <div class="modal fade" id="modalKumpul" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3>PERINGATAN <i class="fa fa-exclamation"></i></h3>
                    </div>
                    <div class="modal-body">
                      <center>
                        <h1>ANDA YAKIN ???</h1><hr>
                        <button type="button" data-dismiss="modal" class="btn btn-lg btn-flat btn-warning btn-block">
                        BELUM
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <form>
                        <input type="submit" name="kumpulkan" id="kumpulkan" class="btn btn-lg btn-flat btn-danger btn-block" value="YA">
                        <?php
                        if ($_REQUEST['kumpulkan'] == "YA") {

                          setcookie('soal',null,time()+0);
                          $krj->hapusKet($isi[0]);
                          header("location:quiz.php");
                        }
                        ?>
                        </form>
                      </center>
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
<script type="text/javascript">
// var nis   = '<?php echo $isi[0]; ?>';
var kuki  = parseInt(<?php echo $_REQUEST['kuki']; ?>);
var detik = kuki;
var menit = 0;
var jam   = 0;
while(detik > 60){
  menit += 1;
  detik -= 60;
}
while(menit > 60){
  jam += 1;
  menit -= 60;
}
function hitung() {
setTimeout(hitung,1000);
if(menit < 10 && jam == 0){
var peringatan = 'style="color:red"';
}
if(detik < 1 && menit == 0 && jam == 0){
  alert("WAKTU HABIS !!");
  window.location="quizdead.php";
}
$('#timer').html(
'<h1 align="center"'+peringatan+'>' + jam + ' : ' + menit + ' : ' + detik + '</h1><hr>'
);
// $.ajax({
//   url: 'updateTerus.php',
//   type: 'GET',
//   data: 'kuki='+kuki+'&nis='+nis,
//   success:function(CallBack){
//     kuki = CallBack;
//   }
// });
kuki--;
detik--;
if(detik < 0) {
    detik = 59;
    menit--;
      if(menit < 0) {
      menit = 59;
      jam--;
      if(jam < 0) {                                                                 
        clearInterval();
      }
    }
  }
return kuki;
}    
hitung();
// return detik;
</script>
<script>
$(document).ready(function() {
  var nomor = $('#no').text();
  var terakhir = $('#terakhir').val();
  var id_ts = $('#id_ts').val();
  var sudah = $('#sudah').val();
  var kd_soal = $('#sudah').attr('name');
  var id_soal = $('.jawaban').attr('name');
  if (sudah != "" && kd_soal == id_soal) {
    $('.'+sudah).addClass('btn-success');
    $('.'+sudah+sudah).css({
      'background-color': 'lightgreen',
      'border' : 'black 1px solid'
    });
  }
  if (nomor == 1) {
    $('#mundur').fadeOut();
  }
  else if(nomor == terakhir){
    $('#lanjut').fadeOut();
  }
  $('#mundur').click(function() {
    var mapel = $('#mapel').val();
    var ke = parseFloat(document.getElementById('ke').value);
    var kek = ke-1;
    window.location="soal.php?mapel="+mapel+"&ke="+kek+"&kuki="+kuki;
  });
  $('#lanjut').click(function() {
    var mapel = $('#mapel').val();
    var ke = parseFloat(document.getElementById('ke').value);
    var kek = ke+1;
    window.location="soal.php?mapel="+mapel+"&ke="+kek+"&kuki="+kuki;
  });
  $('.jum').click(function() {
    var mapel = $('#mapel').val();
    var nomor = $(this).text()-1;
    window.location="soal.php?mapel="+mapel+"&ke="+nomor+"&kuki="+kuki;
  });
  $('#kumpulkan').click(function() {
    // window.location="quiz.php";
  });
  $('.menjawab').click(function() {
    var mapel = "<?php echo $_REQUEST['mapel']; ?>";
    var kuki = "<?php echo $_REQUEST['kuki']; ?>";
    var menjawab = $(this).attr('name');
    var id_soal = $('#id_soal').val();
    var nis = $('#nis').val();
    // $('#kumpulkan').text(jawab);
    if (menjawab == 'A') {
      $('.A').removeClass('btn-default');
      $('.A').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      // $('.AA').removeClass('btn-default');
      $('.AA').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (menjawab == 'B') {
      $('.B').removeClass('btn-default');
      $('.B').addClass('btn-success');
      $('.A').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (menjawab == 'C') {
      $('.C').removeClass('btn-default');
      $('.C').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.A').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (menjawab == 'D') {
      $('.D').removeClass('btn-default');
      $('.D').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.A').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (menjawab == 'E') {
      $('.E').removeClass('btn-default');
      $('.E').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.A').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
    }

    $.ajax({
      url: 'yojawab.php',
      type: 'GET',
      data: "jawab="+menjawab+"&id_soal="+id_soal+"&nis="+nis+"&mapel="+mapel+"&kuki="+kuki,
      success:function(menjawab){
        $('#jawaban').html(menjawab);
        // var kd_soal = $('.jum').attr('id');        
      }
    });
  });
  $('.jawaban').click(function() {
    var mapel = "<?php echo $_REQUEST['mapel']; ?>";
    var kuki = "<?php echo $_REQUEST['kuki']; ?>";
    var jawab = $(this).val();
    var id_soal = $('#id_soal').val();
    var nis = $('#nis').val();
    // $('#kumpulkan').text(jawab);
    if (jawab == 'A') {
      $('.A').removeClass('btn-default');
      $('.A').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      // $('.AA').removeClass('btn-default');
      $('.AA').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (jawab == 'B') {
      $('.B').removeClass('btn-default');
      $('.B').addClass('btn-success');
      $('.A').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (jawab == 'C') {
      $('.C').removeClass('btn-default');
      $('.C').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.A').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.E').removeClass('btn-success');

     $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (jawab == 'D') {
      $('.D').removeClass('btn-default');
      $('.D').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.A').removeClass('btn-success');
      $('.E').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
      $('.EE').css({
        'background-color' : 'white',
        'border' : 'none'
      });
    }
    else if (jawab == 'E') {
      $('.E').removeClass('btn-default');
      $('.E').addClass('btn-success');
      $('.B').removeClass('btn-success');
      $('.C').removeClass('btn-success');
      $('.D').removeClass('btn-success');
      $('.A').removeClass('btn-success');

      $('.AA').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.BB').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.CC').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.DD').css({
        'background-color' : 'white',
        'border' : 'none'
      });
      $('.EE').css({
        'background-color' : 'lightgreen',
        'border' : 'black 1px solid'
      });
    }

    $.ajax({
      url: 'yojawab.php',
      type: 'GET',
      data: "jawab="+jawab+"&id_soal="+id_soal+"&nis="+nis+"&mapel="+mapel+"&kuki="+kuki,
      success:function(jawabanku){
        $('#jawaban').html(jawabanku);
        // var kd_soal = $('.jum').attr('id');
      }
    });
  });
});
</script>
</body>
</html>