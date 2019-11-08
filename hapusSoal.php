<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusSatuSoal($_GET['kd_soal']);
?>