<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusKelas($_GET['kelas']);
?>