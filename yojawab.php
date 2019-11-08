<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->jawab($_GET['id_soal'],$_GET['jawab'],$_GET['nis']);
mysql_query("UPDATE jawaban SET ket = 'soal.php?mapel=$_GET[mapel]&ke=0&kuki=$_GET[kuki]' WHERE nis = '$_GET[nis]'");
setcookie('soal','soal.php?mapel='.$_GET['mapel'].'&ke=0&kuki='.$_GET['kuki'],time()+$_GET['kuki']);
?>