<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$str = $_GET['password'];
$pass = md5($str);
$krj->updateSiswa($_GET['nis'],$_GET['username'],$pass);
?>