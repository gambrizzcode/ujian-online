<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusSoal($_GET['id_ts'],$_GET['katagori']);
$krj->hapusTs($_GET['mapel']);
?>