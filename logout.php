<?php
session_start();

// include 'index.class.php';
// $sambung = new sambung();
// $krj = new kerja();

// $s = $_SESSION['password'];
// $siswa = md5($s);

// $p = $_SESSION['passwordguru'];
// $pass = md5($p);

// mysql_query("UPDATE siswa SET status = '0' WHERE username = '$_SESSION[username]' AND password = '$siswa'");
// mysql_query("UPDATE guru SET status = '0' WHERE username = '$_SESSION[usernameguru]' AND password = '$pass'");

session_destroy();
header("location:index.php");
?>