<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if (!$_SESSION['username'] && !$_SESSION['password']) {
  header("location:index.php");
}
else{
  $user = $_SESSION['username'];
  $pass =  $_SESSION['password'];
  $enpass = md5($pass);  

  $data = mysql_query("SELECT * FROM siswa WHERE username = '$user' AND password = '$enpass'");
  $isi = mysql_fetch_array($data);

  setcookie('soal',null,time()+0);
  $krj->hapusKet($isi[0]);

  header("location:quiz.php");
}
?>