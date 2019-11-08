<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$kelas = $_GET['kelas'];
$query = mysql_query("SELECT * FROM jurusan");
$row   = mysql_fetch_array($query);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3><i class="fa fa-edit"></i> EDIT KELAS <?php echo $row[0]; ?></h3>
		</div>
		<div class="modal-body">
			<label>KELAS : <?php echo $row[0]; ?></label><br>
			<input type="hidden" id="newkelas" value="<?php echo $row[0]; ?>">
			<label>JURUSAN</label>
			<input type="text" class="form-control" id="newjurusan" value="<?php echo $row[1] ?>"><br>
			<label>KELOMPOK</label>
			<select id="newkelompokk" class="form-control">
				<option value="BISMAN">BISMAN</option>
				<option value="TEKNIK">TEKNIK</option>
			</select><hr>
			<button type="button" id="updatekelas" class="btn btn-flat btn-primary pull-right"><i class="fa fa-update"></i> UPDATE</button><br><br>
			<label id="tingkatdua"></label>
		</div>
	</div>
</div>