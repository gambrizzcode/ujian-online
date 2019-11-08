<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
$id_ts = $_REQUEST['id_ts'];
$ambil = mysql_query("SELECT * FROM membuat WHERE id_ts = '$id_ts'");
$dapat = mysql_fetch_array($ambil);
header("Content-type:application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=".$dapat[1].".xls");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SOAL </title>
</head>
<body>
	<center>
		Yayasan Pembina Lembaga Pendidikan (YPLP) Dasmen PGRI Provinsi Jawa Timur<br>
		<b style="font-size:24px">SMK PGRI 05 JEMBER</b><br>
		<b>PROGRAM KEAHLIAN REKAYASA PERANGKAT LUNAK</b><br>
		Jalan Krakatau No. 60 Telp. / Fax. 0336 – 321378<br>
		Kencong – Jember<hr>
		<!-- <b style="font-size: 30px"><?php // echo strtoupper($_REQUEST['judul']); ?></b><hr> -->
	</center>
	<?php
	$no = 1;
	$query = mysql_query("SELECT * FROM soal WHERE id_ts = '$_REQUEST[id_ts]'");
	while ($row = mysql_fetch_array($query)) { ?>
	<div>
		<table class="table">
			<tr>
				<td><?php echo $no++."."; ?></td>
				<td><?php echo $row[2]; ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					A. <?php echo $row[4]; ?> <br>
					B. <?php echo $row[5]; ?> <br>
					C. <?php echo $row[6]; ?> <br>
					D. <?php echo $row[7]; ?> <br>
					E. <?php echo $row[8]; ?> <br>
				</td>
			</tr>
		</table>
	</div>
	<?php } ?>
</body>
</html>