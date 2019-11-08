<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

if ($_FILES['gambar']['name'] == "") {
	
}elseif($_FILES['gambar']['name'] != ""){
	move_uploaded_file($_FILES['gambar']['tmp_name'], "images/".$_FILES['gambar']['name']);//gambar

}else{

}

if ($_FILES['audio']['name'] == "") {
	
}elseif($_FILES['audio']['name'] != ""){
	move_uploaded_file($_FILES['audio']['tmp_name'], "audio/".$_FILES['audio']['name']);//audio
}else{
	
}

$krj->simpanSatuSoal($_POST['kd_soal'],$_POST['id_ts'],$_POST['soal'],$_FILES['gambar']['name'],$_FILES['audio']['name'],$_POST['pila'],$_POST['pilb'],$_POST['pilc'],$_POST['pild'],$_POST['pile'],$_POST['kunci'],$_POST['bab']);

header("location:quizisi.php?id_ts=".$_POST['id_ts']);
?>