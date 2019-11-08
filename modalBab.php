<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>Edit Nama Bab <b><i><?php echo $_GET['bab']; ?></i></b></h3>
		</div>
		<div class="modal-body">
			<h4>Edit Nama Bab Menjadi : </h4>
			<input type="text" id="newbab" class="form-control input-lg" value="<?php echo $_GET['bab']; ?>" placeholder="Nama Bab Baru..">
			<br>
			<br>
			<button type="button" class="btn btn-success btn-flat btn-lg btn-block TombolUpdateBab" id="<?php echo $_GET['id_ts']; ?>" name="<?php echo $_GET['bab']; ?>">
				<i class="fa fa-upload"></i> UPDATE
			</button>
			<hr>
			<div id="hasilUpdateBab"></div>
		</div>
	</div>
</div>