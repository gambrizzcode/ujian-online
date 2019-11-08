<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$data = mysql_query("SELECT * FROM jawaban WHERE nis = '$_GET[nis]'");
$isi  = mysql_fetch_array($data);

$str  = $isi['ket'];
$panjang = strlen($isi['ket']);
$depantok = substr($str,0,$panjang-4);

$jadi = $depantok.$_GET['kuki'];
print_r($jadi);

mysql_query("UPDATE jawaban SET ket = '$jadi' WHERE nis = '$_GET[nis]'");

echo $_GET['kuki'];
?>