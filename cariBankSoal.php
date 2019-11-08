<?php
include 'index.class.php';
$sambung = new sambung();
$krj = new kerja();

?>
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs bg-info">
							<li class="active" style="width: 49%">
								<a href="#tab_pane1" data-toggle="tab"><h4><b>Soal Tayang</b></h4></a>
							</li>
							<li style="width: 49%">
								<a href="#tab_pane2" data-toggle="tab"><h4><b>Soal Tidak Tayang</b></h4></a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_pane1">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs bg-danger">
									<?php
									//terpakai									
									$queryBab = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel like '$_GET[katagori]%' AND soal.soal like '%$_GET[soal]%' GROUP BY soal.bab");
									while ($tab = mysql_fetch_array($queryBab)) {
									?>
										<li>
											<a href="#tab_isi<?php echo $tab['bab']; ?>" data-toggle="tab">
												<b><?php echo $tab['bab']; ?></b>
												<a class="dropdown-toggle" data-toggle="dropdown">
													Opsi <span class="caret"></span>
												</a>
												<ul class="dropdown-menu">
													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modalBab<?php echo $tab['bab']; ?>"><i class="fa fa-trash"></i> HAPUS</button>
													</a></li>

													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm editBab" id="<?php echo $tab['bab']; ?>" name="<?php echo $isi['id_ts']; ?>"><i class="fa fa-edit"></i> EDIT</button>
													</a></li>
												</ul>
											</a>
										</li>
										
										<div class="modal modal-danger fade" id="modalBab<?php echo $tab['bab']; ?>" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h3>Yakin Hapus Bab <b><i><?php echo $tab['bab']; ?></i></b> Dan Seluruh Soal - Soal Didalamnya ???</h3>
													</div>
													<div class="modal-body">
														<button type="button" class="btn btn-success btn-block btn-lg btn-flat hapusBab" id="<?php echo $tab['bab']; ?>" name="<?php echo $isi['id_ts']; ?>"><i class="fa fa-trash"></i> HAPUS!!!</button>
														<hr>
														<div id="hasilHapusBab"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modalEditBab" role="dialog" tabindex="-1" aria-hidden="true"></div>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<?php
									//terpakai
									$queryBab1 = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel like '$_GET[katagori]%' AND soal.soal like '%$_GET[soal]%' GROUP BY soal.bab");
									while ($tab1 = mysql_fetch_array($queryBab1)) {
									$queryBabIsi = mysql_query("SELECT * FROM soal INNER JOIN membuat ON soal.id_ts = membuat.id_ts WHERE membuat.mapel like '$_GET[katagori]%' AND soal.soal like '%$_GET[soal]%' AND soal.bab = '$tab1[bab]'"); ?>
									<div class="tab-pane" id="tab_isi<?php echo $tab1['bab']; ?>">
									<?php
									while ($tabisi = mysql_fetch_array($queryBabIsi)) { ?>
										<?php //echo $tabIsi['soal']; ?>

<!-- ================================================================================================================================== -->
				<div class="box box-danger">
				<div class="box-body">
				  <h2>
				  <button type="button" class="btn btn-flat bg-navy tambahkan" name="<?php echo $tabisi[1]; ?>" id="<?php echo $tabisi[0]; ?>"><i class="fa fa-chevron-left"></i> &nbsp; TAMBAHKAN KE SOAL ANDA &nbsp; <i class="fa fa-refresh" id="ikhon"></i></button> 
				  &nbsp; 
				  <div id="ketTambahkan" style="display: none"></div>
				  <button type="button" class="btn btn-flat bg-orange edit" id="<?php echo $tabisi[0]; ?>"><i class="fa fa-edit"></i> EDIT SOAL</button>
				  &nbsp; 
				  <button type="button" class="btn btn-flat bg-maroon" data-toggle="modal" data-target="#modal<?php echo $tabisi[0]; ?>">
					<i class="fa fa-trash"></i> HAPUS SOAL
				  </button>
				  <div class="modal fade" id="modal<?php echo $tabisi[0]; ?>" role="dialog">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h3>YAKIN HAPUS SOAL INI ??</h3>
						</div>
						<div class="modal-body">
						  <center>
							<button type="button" class="btn btn-flat btn-danger btn-lg hapus" id="<?php echo $tabisi[0]; ?>"><i class="fa fa-trash"></i> HAPUS SOAL</button> 
							&nbsp;
							<button type="button" class="btn btn-flat btn-default btn-lg" data-dismiss="modal">
							  <i class="fa fa-close"></i> BATAL
							</button>
							<div id="ketHapus" style="display: none"></div>
						  </center>
						</div>
					  </div>
					</div>
				  </div>
				  </h2><hr>
				  <?php echo $tabisi['soal']; ?>
				  <br>
				  <?php
				  if ($tabisi['gambar'] != "" ) { ?>

				  <img src="images/<?php echo $tabisi['gambar']; ?>" width="50%">

				  <?php }else{}
				  if ($tabisi['audio'] != "") { ?>

				  <audio src="audio/<?php echo $tabisi['audio']; ?>" autobuffer controls></audio>

				  <?php } ?>
				  <hr>
				  <table>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>A. </b></h4></td>
						<td><?php echo $tabisi['pila']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>B. </b></h4></td>
						<td><?php echo $tabisi['pilb']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>C. </b></h4></td>
						<td><?php echo $tabisi['pilc']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>D. </b></h4></td>
						<td><?php echo $tabisi['pild']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>E. </b></h4></td>
						<td><?php echo $tabisi['pile']; ?></td>
					  </tr>
				  </table>

				  <h4><b>Kunci Jawaban : <?php echo $isi['kunci']; ?></b></h4>
				</div>
			  </div>
<!-- ================================================================================================================================== -->
									<?php
									} ?>
									</div>
									<?php
									}
									?>
								</div>
							</div>
							</div>
							<div class="tab-pane" id="tab_pane2">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs bg-warning">
									<?php
									//tidak terpakai
									$queryBa = mysql_query("SELECT * FROM soal WHERE id_ts = '$_GET[katagori]' AND soal like '%$_GET[soal]%' GROUP BY bab");
									while ($ta = mysql_fetch_array($queryBa)) {
									?>
										<li>
											<a href="#tab_is<?php echo $ta['bab']; ?>" title="<?php echo $ta['bab']; ?>" data-toggle="tab">
											<b><?php echo $ta['bab']; ?></b>
											<a class="dropdown-toggle" data-toggle="dropdown">
													Opsi <span class="caret"></span>
												</a>
												<ul class="dropdown-menu">
													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modalTidakTerpakaiBab<?php echo $ta['bab']; ?>"><i class="fa fa-trash"></i> HAPUS</button>
													</a></li>

													<li role="presentation"><a href="#" tabindex="-1" role="menu-item">
														<button type="button" class="btn btn-link btn-sm editBabu" id="<?php echo $ta['bab']; ?>" name="<?php echo $_GET['katagori']; ?>"><i class="fa fa-edit"></i> EDIT</button>
													</a></li>
												</ul>
											</a>
										</li>
										
										<div class="modal modal-danger fade" id="modalTidakTerpakaiBab<?php echo $ta['bab']; ?>" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h3>Yakin Hapus Bab <b><i><?php echo $ta['bab']; ?></i></b> Dan Seluruh Soal - Soal Didalamnya ???</h3>
													</div>
													<div class="modal-body">
														<button type="button" class="btn btn-success btn-block btn-lg btn-flat hapusBabu" id="<?php echo $ta['bab']; ?>" name="<?php echo $_GET['katagori']; ?>"><i class="fa fa-trash"></i> HAPUS!!!</button>
														<hr>
														<div id="hasilHapusBabu"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modalEditBabu" role="dialog" tabindex="-1" aria-hidden="true"></div>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<?php
									//tidak terpakai
									$queryBab2 = mysql_query("SELECT * FROM soal WHERE id_ts = '$_GET[katagori]' AND soal like '%$_GET[soal]%' GROUP BY bab");
									while ($tab2 = mysql_fetch_array($queryBab2)) {
									$queryBabIs = mysql_query("SELECT * FROM soal WHERE id_ts = '$_GET[katagori]' AND soal like '%$_GET[soal]%' AND bab = '$tab2[bab]'"); ?>
									<div class="tab-pane" id="tab_is<?php echo $tab2['bab']; ?>">
									<?php
									while ($tabis = mysql_fetch_array($queryBabIs)) { ?>
										<?php //echo $tabIs['soal']; ?>
<!-- ================================================================================================================================== -->
			  <div class="box box-danger">
				<div class="box-body">
				  <h2>
				  <button type="button" class="btn btn-flat bg-navy tambahkan" name="<?php echo $tabis[1]; ?>" id="<?php echo $tabis[0]; ?>"><i class="fa fa-chevron-left"></i> &nbsp; TAMBAHKAN KE SOAL ANDA &nbsp; <i class="fa fa-refresh" id="ikhon"></i></button> 
				  &nbsp; 
				  <div id="ketTambahkan" style="display: none"></div>
				  <button type="button" class="btn btn-flat bg-orange edit" id="<?php echo $tabis[0]; ?>"><i class="fa fa-edit"></i> EDIT SOAL</button>
				  &nbsp; 
				  <button type="button" class="btn btn-flat bg-maroon" data-toggle="modal" data-target="#modal<?php echo $tabis[0]; ?>">
					<i class="fa fa-trash"></i> HAPUS SOAL
				  </button>
				  <div class="modal fade" id="modal<?php echo $tabis[0]; ?>" role="dialog">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h3>YAKIN HAPUS SOAL INI ??</h3>
						</div>
						<div class="modal-body">
						  <center>
							<button type="button" class="btn btn-flat btn-danger btn-lg hapus" id="<?php echo $tabis[0]; ?>"><i class="fa fa-trash"></i> HAPUS SOAL</button> 
							&nbsp;
							<button type="button" class="btn btn-flat btn-default btn-lg" data-dismiss="modal">
							  <i class="fa fa-close"></i> BATAL
							</button>
							<div id="ketHapus" style="display: none"></div>
						  </center>
						</div>
					  </div>
					</div>
				  </div>
				  </h2><hr>
				  <?php echo $tabis['soal']; ?>
				  <br>
				  <?php
				  if ($tabis['gambar'] != "" ) { ?>

				  <img src="images/<?php echo $tabis['gambar']; ?>" width="50%">

				  <?php }else{}
				  if ($tabis['audio'] != "") { ?>

				  <audio src="audio/<?php echo $tabis['audio']; ?>" autobuffer controls></audio>

				  <?php } ?>
				  <hr>
				  <table>
					<tbody>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>A. </b></h4></td>
						<td><?php echo $tabis['pila']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>B. </b></h4></td>
						<td><?php echo $tabis['pilb']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>C. </b></h4></td>
						<td><?php echo $tabis['pilc']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>D. </b></h4></td>
						<td><?php echo $tabis['pild']; ?></td>
					  </tr>
					  <tr valign="middle">
						<td style="padding-right: 5px"><h4><b>E. </b></h4></td>
						<td><?php echo $tabis['pile']; ?></td>
					  </tr>
					</tbody>
				  </table>

				  <h4><b>Kunci Jawaban : <?php echo $tabis['kunci']; ?></b></h4>
				</div>
			  </div>			
<!-- ================================================================================================================================== -->
									<?php
									} ?>
									</div>
									<?php
									}
									?>
								</div>
							</div>
							</div>
						</div>
					</div>