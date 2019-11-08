<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->updateBab($_GET['bab'],$_GET['id_ts'],$_GET['babLama']);
?>
<h1 class="alert alert-success">Update Bab Berhasil..</h1>