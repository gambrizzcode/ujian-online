<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$krj->simpanSiswa($_GET['nis'],$_GET['nopes'],$_GET['nama'],$_GET['kelas'],$_GET['username'],md5($_GET['pass']));
?>