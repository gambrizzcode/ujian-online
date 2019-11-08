<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanMapel($_GET['mapel'],$_GET['nama'],$_GET['kelompok']);
?>