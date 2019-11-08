<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusSoalPalsu($_GET['kd_soal'],$_GET['katagori']);

?>