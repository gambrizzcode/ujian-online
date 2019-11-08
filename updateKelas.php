<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->updateKelas($_GET['kelas'],$_GET['jurusan'],$_GET['kelompok']);
?>