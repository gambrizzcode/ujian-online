<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Print Nilai</title>
  <link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.css">
  <link rel="icon" href="images/exam.png">
</head>
<script>
function prin(){
  window.print();
  window.location="admin.php";
}
</script>
<body onload="prin()">
  <form>
  <center>
  <h4>DAFTAR NILAI KELAS <?php echo $_GET['kelas']; ?> MAPEL <?php echo $_GET['mapel']; ?></h4>
              <table class="table table-hovered table-condensed" id="daftarnilai">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>NAMA</th>
                    <th>NILAI</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $no = 1;
                  $ambilnis = mysql_query("SELECT * FROM siswa WHERE kelas = '$_GET[kelas]'");
                  while ($nis = mysql_fetch_array($ambilnis)) { ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $nis['nis']; ?></td>
                    <td><?php echo $nis['nama']; ?></td>
                    <td>
                      <?php
                      $lihatsoal = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel = '$_GET[mapel]'");
                      $seluruh = mysql_num_rows($lihatsoal);
                      $luruh = mysql_fetch_array($lihatsoal);
                      $nilaikelas = mysql_query("SELECT * FROM jawaban INNER JOIN soal ON jawaban.kd_soal = soal.kd_soal INNER JOIN membuat ON membuat.id_ts = soal.id_ts WHERE jawaban.jawaban = soal.kunci AND jawaban.nis = '$nis[0]' AND membuat.mapel = '$_GET[mapel]'");
                      $inilai = mysql_num_rows($nilaikelas);//benar
                      $score = 100/$seluruh;//score
                      echo $inilai*$score;//nilai
                      ?>
                    </td>
                  </tr>
                  <?php  }?>
                </tbody>
              </table>
  </center>
  </form>
</body>
</html>