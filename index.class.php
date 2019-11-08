<?php
session_start();//memulai session
ob_start();//mengatasi header
date_default_timezone_set('Asia/Jakarta');//set waktu
ini_set("display_errors","off");//menghilangkan error

class sambung{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $name = "exam";

	function __construct(){
		mysql_connect($this->host,$this->user,$this->pass);
		mysql_select_db($this->name);
	}
}
class kerja{
	function login($username,$password){
		$aha  = mysql_query("SELECT * FROM siswa WHERE username = '$username' AND password = '$password'");
		// AND status = '0'
		$enek =  mysql_num_rows($aha);
		// if ($enek == 1) {
			// mysql_query("UPDATE siswa SET status = '1' WHERE username = '$username' AND password = '$password'");
		// }
		echo $enek;
		return $enek;
	}
	function loginguru($gusername,$gpassword){
		$gpass = md5($gpassword);
		$gaha  = mysql_query("SELECT * FROM guru WHERE username = '$gusername' AND password = '$gpass'");
		// AND status = '0'
		$genek =  mysql_num_rows($gaha);
		// if ($genek == 1) {
			// mysql_query("UPDATE guru SET status = '1' WHERE username = '$gusername' AND password = '$gpass'");
		// }
		echo $genek;
		return $genek;
	}
	function simpanSiswa($nis,$nopes,$nama,$kelas,$username,$password){
		mysql_query("INSERT INTO siswa VALUES('$nis','$nopes','$nama','$kelas','$username','$password','0')");
	}
	function simpanGuru($kd_guru,$nama,$username,$password,$mapel){
		mysql_query("INSERT INTO guru VALUES('$kd_guru','$nama','$username','$password','$mapel','0')");
	}
	function simpanTopikSoal($id_ts,$mapel,$durasi,$exp,$batas){
		mysql_query("INSERT INTO membuat VALUES('$id_ts','$mapel','$durasi','$exp','$batas')");
	}
	function updateTopikSoal($id_ts,$durasi,$jumlah,$batas){
		mysql_query("UPDATE membuat SET durasi = '$durasi', jumlah = '$jumlah', batas = '$batas' WHERE id_ts = '$id_ts'");
	}
	function simpanSatuSoal($kd_soal,$id_ts,$soal,$gambar,$audio,$pila,$pilb,$pilc,$pild,$pile,$kunci,$ket){
		mysql_query("INSERT INTO soal VALUES('$kd_soal','$id_ts','$soal','$gambar','$audio','$pila','$pilb','$pilc','$pild','$pile','$kunci','$ket')");
	}
	function simpanSoal($kd_soal,$soal,$gambar,$audio,$a,$b,$c,$d,$e,$kunci,$ket){
		mysql_query("UPDATE soal SET soal = '$soal', gambar = '$gambar', audio = '$audio', pila = '$a', pilb = '$b', pilc = '$c', pild = '$d', pile = '$e', kunci = '$kunci', bab = '$ket' WHERE kd_soal = '$kd_soal'");
	}
	function hapusSoal($id_ts,$katagori){
		mysql_query("UPDATE soal SET id_ts = '$katagori' WHERE id_ts = '$id_ts'");
		mysql_query("DELETE FROM membuat WHERE id_ts = '$id_ts'");
	}
	function hapusSoalPalsu($kd_soal,$katagori){
		mysql_query("UPDATE soal SET id_ts = '$katagori' WHERE kd_soal = '$kd_soal'");
	}
	function hapusSatuSoal($kd_soal){
		mysql_query("DELETE FROM soal WHERE kd_soal = '$kd_soal'");
	}
	function updateSiswa($nis,$username,$password){
		mysql_query("UPDATE siswa SET username = '$username', password = '$password' WHERE nis = '$nis'");
	}
	function updateGuru($kd,$username,$password){
		mysql_query("UPDATE guru SET username = '$username', password = '$password' WHERE kd_guru = '$kd'");
	}

	function jawaban($id_jawaban,$kd_soal,$nis,$ket){
		mysql_query("INSERT INTO jawaban VALUES('$id_jawaban','$kd_soal','$nis','','$ket')");
	}
	function jawab($id_soal,$jawaban,$nis){
		mysql_query("UPDATE jawaban SET jawaban = '$jawaban' WHERE kd_soal = '$id_soal' AND nis = '$nis'");
	}

	function simpanMapel($mapel,$nama,$kelompok){
		mysql_query("INSERT INTO mapel VALUES('$mapel','$nama','$kelompok')");
	}
	function updateMapel($mapel,$nama,$kelompok){
		mysql_query("UPDATE mapel SET nama = '$nama', kelompok = '$kelompok' WHERE mapel = '$mapel'");
	}
	function hapusMapel($mapel){
		mysql_query("DELETE FROM mapel WHERE mapel = '$mapel'");
	}
	function hapusGuru($mapel){
		mysql_query("DELETE FROM guru WHERE mapel = '$mapel'");
	}
	function hapusTs($mapel){
		mysql_query("DELETE FROM membuat WHERE mapel = '$mapel'");
	}
	function simpanKelas($kelas,$jurusan,$kelompok){
		mysql_query("INSERT INTO jurusan VALUES('$kelas','$jurusan','$kelompok')");
	}
	function updateKelas($kelas,$jurusan,$kelompok){
		mysql_query("UPDATE jurusan SET jurusan = '$jurusan', kelompok = '$kelompok' WHERE kelas = '$kelas'");
	}
	function hapusKelas($kelas){
		mysql_query("DELETE FROM jurusan WHERE kelas = '$kelas'");
	}
	function hapusKet($nis){
		mysql_query("UPDATE jawaban SET ket = '' WHERE nis = '$nis'");
	}
	function hapusSemua(){
		mysql_query("TRUNCATE TABLE siswa");
	}
	function hapusBeberapa($nis,$nopes){
		mysql_query("DELETE FROM siswa WHERE nis = '$nis' AND nopes = '$nopes'");
	}
	function tambahkanTidakTerpakai($kd_soal,$tujuan){
		mysql_query("UPDATE soal SET id_ts = '$tujuan' WHERE kd_soal = '$kd_soal'");
	}
	function tambahkanCopy($kd_soal,$tujuan){
		$data = mysql_query("SELECT * FROM soal WHERE kd_soal = '$kd_soal'");
		$isi  = mysql_fetch_array($data);

		$urut = mysql_query("SELECT * FROM soal ORDER BY kd_soal DESC");
		$arat = mysql_fetch_array($urut);
		$urat = $arat[0]+1;

		mysql_query("INSERT INTO soal VALUES('$urat','$tujuan','$isi[2]','$isi[3]','$isi[4]','$isi[5]','$isi[6]','$isi[7]','$isi[8]','$isi[9]','$isi[10]','$isi[11]')");
	}
	function hapusBab($bab,$id_ts){
		mysql_query("DELETE FROM soal WHERE bab = '$bab' AND id_ts = '$id_ts'");
		mysql_query("DELETE FROM bab WHERE bab = '$bab' AND id_ts = '$id_ts'");
	}
	function updateBab($bab,$id_ts,$babLama){
		mysql_query("UPDATE soal SET bab = '$bab' WHERE bab = '$babLama' AND id_ts = '$id_ts'");
		mysql_query("UPDATE bab SET bab = '$bab' WHERE id_ts = '$id_ts'");
	}
	function insertJumlahBab($id_ts,$bab,$jumlah){
		mysql_query("INSERT INTO bab VALUES('$id_ts','$bab','$jumlah')");
	}
	function updateJumlahBab($id_ts,$bab,$jumlah){
		mysql_query("UPDATE bab SET jumlah = '$jumlah' WHERE id_ts = '$id_ts' AND bab = '$bab'");
	}
}
?>