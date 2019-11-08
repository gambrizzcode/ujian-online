<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
	$login = $krj->login($_GET["username"],md5($_GET["password"]));
	if ($login == 1) {
		$username = $_GET["username"];
		$password = $_GET["password"];
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
	}else{
		
	}
?>