<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

// var_dump($_GET);

if ($_GET['asal'] == $_GET['katagori']) {//tidak terpakai
	$krj->tambahkanTidakTerpakai($_GET['kd_soal'],$_GET['tujuan']);//langsung update id_ts
}elseif($_GET['asal'] != $_GET['katagori'] && $_GET['asal'] != $_GET['tujuan']){
	$krj->tambahkanCopy($_GET['kd_soal'],$_GET['tujuan']);//gandakan soal
}		
?>