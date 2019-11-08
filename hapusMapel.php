<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->hapusMapel($_GET['mapel']);
$krj->hapusGuru($_GET['mapel']);
$krj->hapusTs($_GET['mapel']);
?>