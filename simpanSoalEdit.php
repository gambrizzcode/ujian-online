<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

echo "<pre>";
print_r($_POST);
echo "</pre>";

if ($_POST['gambarLama'] == "" && $_FILES['gambar']['name'] != "") {//cek gambar
	move_uploaded_file($_FILES['gambar']['tmp_name'], "images/".$_FILES['gambar']['name']);
	$gambar = $_FILES['gambar']['name'];
}elseif($_POST['gambarLama'] != "" && $_FILES['gambar']['name'] != ""){
	unlink("images/".$_POST['gambarLama']);
	move_uploaded_file($_FILES['gambar']['tmp_name'], "images/".$_FILES['gambar']['name']);
	$gambar = $_FILES['gambar']['name'];
}elseif($_POST['gambarLama'] != ""){
	$gambar = $_POST['gambarLama'];
}

if ($_POST['audioLama'] == "" && $_FILES['audio']['name'] != "") {//cek audio
	move_uploaded_file($_FILES['audio']['tmp_name'], "audio/".$_FILES['audio']['name']);
	$audio = $_FILES['audio']['name'];
}elseif($_POST['audioLama'] != "" && $_FILES['audio']['name'] != ""){
	unlink("audio/".$_POST['audioLama']);
	move_uploaded_file($_FILES['audio']['tmp_name'], "audio/".$_FILES['audio']['name']);
	$audio = $_FILES['audio']['name'];
}elseif($_POST['audioLama'] != ""){
	$audio = $_POST['audioLama'];
}

$krj->simpanSoal($_POST['kd_soal'],$_POST['soal'],$gambar,$audio,$_POST['pila'],$_POST['pilb'],$_POST['pilc'],$_POST['pild'],$_POST['pile'],$_POST['kunci'],$_POST['bab']);

if ($_POST['numur'] == "") {
	header("location:bankSoal.php");
}else{
	header("location:quizgurutampil.php");
}
?>