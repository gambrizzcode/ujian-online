<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->updateTopikSoal($_GET['id_ts'],$_GET['durasi'],$_GET['exp'],$_GET['batas']);
?>