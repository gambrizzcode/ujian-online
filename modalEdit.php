<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

$mapel = $_GET['mapel'];
$query = mysql_query("SELECT * FROM mapel");
$row   = mysql_fetch_array($query);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3><i class="fa fa-edit"></i> EDIT MAPEL <?php echo $row[1]; ?></h3>
		</div>
		<div class="modal-body">
			<label>KODE MAPEL : <?php echo $row[0]; ?></label><br>
			<input type="hidden" value="<?php echo $row[0]; ?>" id="newmapel">
			<label>NAMA MAPEL</label>
			<input type="text" class="form-control" id="newnama" value="<?php echo $row[1] ?>"><br>
			<label>KELOMPOK</label>
			<select id="newkelompok" class="form-control">
				<option value="BISMAN">BISMAN</option>
				<option value="TEKNIK">TEKNIK</option>
				<option value="SEMUA">SEMUA</option>
			</select><hr>
			<button type="button" id="update" class="btn btn-flat btn-primary pull-right"><i class="fa fa-update"></i> UPDATE</button><br><br>
			<label id="tingkat"></label>
		</div>
	</div>
</div>