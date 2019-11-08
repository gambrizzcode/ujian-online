<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusBeberapa($_GET['nishapus'],$_GET['nopeshapus']);
?>