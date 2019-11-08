<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$mapel = $_GET['mapel'];
$pilihmapel = mysql_query("SELECT * FROM membuat WHERE mapel = '$mapel'");
$ambil = mysql_fetch_array($pilihmapel);

$durasi = $ambil['durasi']*60;

$lihat2 = mysql_query("SELECT * FROM soal INNER JOIN bab ON soal.id_ts = bab.id_ts WHERE soal.id_ts = '$ambil[0]' ORDER BY RAND('$_GET[nis]')");

$queryBab = mysql_query("SELECT * FROM bab WHERE id_ts = '$ambil[0]'");
while ($isiBab = mysql_fetch_array($queryBab)) {
		$idjawaban = md5($_GET['nis'].time().$isiBab['bab']).time();//id_jawaban
		$perbab = mysql_query("SELECT * FROM soal WHERE id_ts = '$ambil[0]' AND bab = '$isiBab[1]' ORDER BY RAND('$_GET[nis]')");
		for ($i=1; $i <= $isiBab['jumlah'] ; $i++) {
			$yok = mysql_fetch_assoc($perbab);
			$krj->jawaban($idjawaban.$i,$yok['kd_soal'],$_GET['nis'],'soal.php?mapel='.$ambil[2].'&ke=0&kuki='.$durasi);
		}

}

setcookie('soal','soal.php?mapel='.$ambil[2].'&ke=0&kuki='.$durasi,time()+$durasi);

?>
<input type="hidden" id="kuki" value="<?php echo $durasi; ?>">