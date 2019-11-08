<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>E-Xam | Daftar Guru</title>
	<link rel="icon" href="images/exam.png">
	<link rel="stylesheet" type="text/css" href="hover/hover.css">
	<link rel="stylesheet" type="text/css" href="mybootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/AdminLTE.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/skins/_all-skins.min.css">
	<link rel="stylesheet" type="text/css" href="AdminLTE/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>
<body class="hold-transition login-page">

		 	<div class="login-box">
			 	<div class="login-logo">
			 		<b>E</b>-Xam<br>
			 		Pendaftaran Guru
			 	</div>
			 	<div class="login-box-body" id="kotak_register">
			 		<div class="form-group has-feedback">
					  <!-- <input type="hidden" id="id_pelanggan" value="<?php //$krj->kodePelanggan(); ?>"><br> -->
					  <div class="form-group has-feedback">
					  	<input type="text" placeholder="KODE GURU.." id="kd_guru" class="form-control">
					  	<span class="fa fa-code form-control-feedback" id="ikon_kd_guru"></span>
					  </div>
					  <div class="form-group has-feedback">
					  	<input type="text" placeholder="NAMA.." id="nama" class="form-control">
					  	<span class="fa fa-pencil form-control-feedback" id="ikon_nama"></span>
					  </div>
					  <div class="form-group has-feedback">
					  	<input type="text" placeholder="USERNAME.." id="username" class="form-control">
					  	<span class="fa fa-envelope form-control-feedback" id="ikon_username"></span>
					  </div>
					  <div class="form-group has-feedback">
					  	<input type="password" placeholder="BUAT PASSWORD.." id="password" class="form-control">
					  	<span class="fa fa-lock form-control-feedback" id="ikon_password"></span>
					  </div>
					  <div class="form-group has-feedback">
					  	<input type="password" placeholder="KONFIRMASI PASSWORD.." id="confirm" class="form-control">
					  	<span class="fa fa-edit form-control-feedback" id="ikon_confirm"></span>
					  </div>
					  <div class="form-group has-feedback">
					  	<select id="mapel" class="form-control">
					  	<?php
					  	$query = mysql_query("SELECT * FROM mapel LEFT JOIN membuat ON mapel.mapel = membuat.mapel");
					  	while ($row=mysql_fetch_array($query)) {
					  		if ($row['id_ts'] == "") { ?>
					  		<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
					  	<?php } } ?>
					  	</select>
					  </div>
					  <button type="button" id="register" class="btn btn-primary btn-block btn-flat"><span class="glyphicon glyphicon-floppy-save"></span> DAFTAR</button>
					  <input type="hidden" id="hasil">
				  </div>
			 	</div>

			 	<center>
			 	<br>
				  <p>Sudah Punya Akun ?</p>
				  <h4><a href="guru.php">--- LOGIN ---</a></h4>
				</center>
			 	<div class="login-box-footer">
			 		<h3 id="tampil"></h3>
			 	</div>
		 	</div>
	<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
	<script src="mybootstrap/js/bootstrap.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.js"></script>
	<script src="bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="slimScroll/jquery.slimscroll.min.js"></script>
	<script src="AdminLTE/js/app.min.js"></script>
<script>
$(document).ready(function() {
	
	$('#kd_guru').focusout(function() {
		if($(this).val().length >= 1){
			$(this).css('box-shadow', '0 0 2px green');
			$('#ikon_kd_guru').removeClass('fa-code');
			$('#ikon_kd_guru').addClass('fa-check text-success');
			$('#ikon_kd_guru').removeClass('fa-close text-danger');
		}
		else{
			$(this).css('box-shadow', '0 0 2px red');
			$(this).focus();
			$('#ikon_kd_guru').removeClass('fa-code');
			$('#ikon_kd_guru').removeClass('fa-check text-success');
			$('#ikon_kd_guru').addClass('fa-close text-danger');
		}
	});
	$('#nama').focusout(function() {
		if($(this).val().length >= 3){
			$(this).css('box-shadow', '0 0 2px green');
			$('#ikon_nama').removeClass('fa-pencil');
			$('#ikon_nama').addClass('fa-check text-success');
			$('#ikon_nama').removeClass('fa-close text-danger');
		}
		else{
			$(this).css('box-shadow', '0 0 2px red');
			$(this).focus();
			$('#ikon_nama').removeClass('fa-pencil');
			$('#ikon_nama').removeClass('fa-check text-success');
			$('#ikon_nama').addClass('fa-close text-danger');
		}
	});
	$('#username').focusout(function() {
		if($(this).val().length >= 3){
			$(this).css('box-shadow', '0 0 2px green');
			$('#ikon_username').removeClass('fa-envelope');
			$('#ikon_username').addClass('fa-check text-success');
			$('#ikon_username').removeClass('fa-close text-danger');
		}
		else{
			$(this).css('box-shadow', '0 0 2px red');
			$(this).focus();
			$('#ikon_username').removeClass('fa-envelope');
			$('#ikon_username').removeClass('fa-check text-success');
			$('#ikon_username').addClass('fa-close text-danger');
		}
	});
	$('#password').focusout(function() {
		if ($(this).val().length >= 8) {
			$(this).css('box-shadow', '0 0 2px green');
			$('#ikon_password').removeClass('fa-lock');
			$('#ikon_password').addClass('fa-check text-success');
			$('#ikon_password').removeClass('fa-close text-danger');
		}
		else{
			$(this).css('box-shadow', '0 0 2px red');
			$(this).focus();
			$(this).attr('placeholder', 'Minimal 8 Karakter..');
			$('#ikon_password').removeClass('fa-pencil');
			$('#ikon_password').removeClass('fa-check text-success');
			$('#ikon_password').addClass('fa-close text-danger');
		}
	});
	$('#confirm').focusout(function() {
		if ($(this).val() == $('#password').val()) {
			$(this).css('box-shadow', '0 0 2px green');
			$('#ikon_confirm').removeClass('fa-edit');
			$('#ikon_confirm').addClass('fa-check text-success');
			$('#ikon_confirm').removeClass('fa-close text-danger');
		}
		else{
			$(this).css('box-shadow', '0 0 2px red');
			$(this).focus();
			$(this).attr('placeholder', 'Harus Sama Dengan Yang Di Atas..');
			$('#ikon_confirm').removeClass('fa-edit');
			$('#ikon_confirm').removeClass('fa-check text-success');
			$('#ikon_confirm').addClass('fa-close text-danger');
		}
	});
	
	$('#register').click(function() {
		var kd_guru = $('#kd_guru').val();
		var nama = $('#nama').val();
		var username = $('#username').val();
		var pass = $('#password').val();
		var confirm = $('#confirm').val();
		var mapel = $('#mapel').val();
		if (kd_guru == "" || nama == "" || pass == "" || confirm == "" || username == "" || mapel == "") {
			$('#tampil').html("HARAP ISI KOLOM DENGAN BENAR !!");
		}
		else{
			$.ajax({
				url: 'simpanGuru.php',
				type: 'GET',
				data: "kd_guru="+kd_guru+"&nama="+nama+"&pass="+pass+"&username="+username+"&mapel="+mapel,
				success:function(data){
					$('#hasil').html(data);
					$('#tampil').html("SELAMAT..!! Anda Telah Terdaftar Sebagai Guru dan Dapat Membuat Soal.");
					$('#kotak_register').hide('100');
				}
			});
		}
	});
	
});
</script>
</body>
</html>