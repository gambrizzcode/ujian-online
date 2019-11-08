<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanTopikSoal($_GET['id_ts'],$_GET['mapel'],$_GET['durasi'],$_GET['exp'],$_GET['batas']);
?>