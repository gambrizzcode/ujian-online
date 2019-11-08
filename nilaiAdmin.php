<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
?>
<br><hr>
			<table class="table table-hovered" id="daftarnilai">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>NO. PESERTA</th>
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
                    <td><?php echo $nis['nopes']; ?></td>
                    <td><?php echo $nis['nama']; ?></td>
                    <td>
                      <?php
                      $lihatsoal = mysql_query("SELECT * FROM membuat WHERE mapel = '$_GET[mapel]'");
                      $seluruh = mysql_fetch_array($lihatsoal);
                      $luruh = mysql_fetch_array($lihatsoal);
                      $nilaikelas = mysql_query("SELECT * FROM jawaban INNER JOIN soal ON jawaban.kd_soal = soal.kd_soal INNER JOIN membuat ON membuat.id_ts = soal.id_ts WHERE jawaban.jawaban = soal.kunci AND jawaban.nis = '$nis[0]' AND membuat.mapel = '$_GET[mapel]'");
                      $inilai = mysql_num_rows($nilaikelas);//benar
                      $score = 100/$seluruh['jumlah'];//score
                      $nilaibenar = $inilai*$score;//nilai
                      if ($nilaibenar < 75) {
                        echo "<span style='color:red'>".$nilaibenar."</span>";
                      }else{
                        echo "<span style='color:green'>".$nilaibenar."</span>";
                      }
                      ?>
                    </td>
                  </tr>
                  <?php  }?>
                </tbody>
              </table>
