<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$cek = mysql_num_rows(mysql_query("SELECT * FROM bab WHERE id_ts = '$_GET[id_ts]' AND bab = '$_GET[bab]'"));

if ($cek == 0) {
	$krj->insertJumlahBab($_GET['id_ts'],$_GET['bab'],$_GET['jumlah']);
}else{
	$krj->updateJumlahBab($_GET['id_ts'],$_GET['bab'],$_GET['jumlah']);
}
?>
<small class="label bg-green">BERHASIL</small>