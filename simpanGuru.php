<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanGuru($_GET['kd_guru'],$_GET['nama'],$_GET['username'],md5($_GET['pass']),$_GET['mapel']);
?>