<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
	
	$login = $krj->loginguru($_GET["usernameguru"],$_GET["passwordguru"]);
	if ($login == 1) {
		$usernameguru = $_GET["usernameguru"];
		$passwordguru = $_GET["passwordguru"];
		$_SESSION["usernameguru"] = $usernameguru;
		$_SESSION["passwordguru"] = $passwordguru;
	}
?>