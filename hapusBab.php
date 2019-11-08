<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusBab($_GET['bab'],$_GET['id_ts']);
?>
<h1 class="alert alert-success">Bab Berhasil Dihapus..</h1>