<?php
session_start();
include_once('lib/head.php');
include_once("lib/check.php");
?>

<body class="skin-black">
	<!--include file header-->
	<?php
	include("lib/header.php");
	$area_kode = $_SESSION['area'];
	?>

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include("lib/menu.php"); ?>
		<aside class="right-side">
			<!-- Main content -->
			<section class="content">



				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">EDIT Master Pagu</header>
							<div class="panel-body table-responsive">
								<form class="form-horizontal tasi-form" method="post" action="master_pagu_edit_submit.php">
									<table class="table table-hover">
										<?php
										$vendor_id = $_GET['vendor_id'];
										$paket_jeniss = $_GET['paket_jenis'];
										$query = "SELECT B.VENDOR_NAMA, A.PAKET_JENIS, A.PAGU_KONTRAK, A.RANKING, A.NO_PJN, A.TGL_PJN, A.NO_RKS,
														A.TGL_RKS, A.NO_SPP, A.TGL_SPP, A.NO_PENAWARAN, A.TGL_PENAWARAN, A.TGL_AKHIR 
														FROM tb_pagu_kontrak A join tb_vendor B WHERE A.VENDOR_ID=B.VENDOR_ID 
														AND A.VENDOR_ID=$vendor_id AND A.PAKET_JENIS=$paket_jeniss";
										$resultQuery = mysqli_query($mysqli, $query);
										while ($rows = mysqli_fetch_row($resultQuery)) {
											$data[] = $rows;
										}
										$vendor_nama		 	= $data[0][0];
										$paket_jenisv 			= $data[0][1];
										$pagu_kontrak	 		= $data[0][2];
										$rangking			 	= $data[0][3];
										$no_pjn				 	= $data[0][4];
										$tgl_pjn				= $data[0][5];
										$no_rks					= $data[0][6];
										$tgl_rks				= $data[0][7];
										$no_spp					= $data[0][8];
										$tgl_spp				= $data[0][9];
										$no_penawaran			= $data[0][10];
										$tgl_penawaran			= $data[0][11];
										$tgl_akhir				= $data[0][12];
										$err					= $_GET['err'];
										$success				= $_GET['scs'];
										?>

										<tr>
											<td>Vendor</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_vendor" data-options="required:true" value="<?php echo $vendor_nama ?>" readonly></input></td>
											<input type="hidden" class="form-control" name="vendor_id" data-options="required:true" value="<?php echo $vendor_id ?>"></input>
											<input type="hidden" class="form-control" name="paket_jenis" data-options="required:true" value="<?php echo $paket_jeniss ?>"></input>
										</tr>
										<tr>
											<td>Paket Jenis</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_paket_jenis" data-options="required:true" value="<?php echo $paket_jenisv ?>" readonly></input></td>
										</tr>
										<tr>
											<td>Nilai Pagu Kontrak Vendor</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_nilai_pagu" data-options="required:true" value="<?php echo $pagu_kontrak ?>" readonly></input></td>
										</tr>
										<tr>
											<td>Rangking</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_rangking" id="nilai" data-options="required:true" value="<?php echo $rangking ?>"></input></td>
										</tr>

										<tr>
											<td>Nomor Perjanjian</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_no_pjn" id="nilai" data-options="required:true" value="<?php echo $no_pjn ?>"></input></td>
										</tr>

										<tr>
											<td>Tanggal Perjanjian</td>
											<td>:</td>
											<td><input type="date" class="form-control" id="var_tgl_pjn" name="var_tgl_pjn" data-options="required:true" value="<?php echo $tgl_pjn ?>"></input></td>
										</tr>

										<tr>
											<td>Nomor RKS</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_no_rks" id="nilai" data-options="required:true" value="<?php echo $no_rks ?>"></input></td>
										</tr>

										<tr>
											<td>Tanggal RKS</td>
											<td>:</td>
											<td><input type="date" class="form-control" id="var_tgl_rks" name="var_tgl_rks" data-options="required:true" value="<?php echo $tgl_rks ?>"></input></td>
										</tr>

										<tr>
											<td>Nomor SPP</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_no_spp" id="nilai" data-options="required:true" value="<?php echo $no_spp ?>"></input></td>
										</tr>

										<tr>
											<td>Tanggal SPP</td>
											<td>:</td>
											<td><input type="date" class="form-control" id="var_tgl_spp" name="var_tgl_spp" data-options="required:true" value="<?php echo $tgl_spp ?>"></input></td>
										</tr>

										<tr>
											<td>Nomor Penawaran</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="var_no_penawaran" id="nilai" data-options="required:true" value="<?php echo $no_penawaran ?>"></input></td>
										</tr>

										<tr>
											<td>Tanggal Penawaran</td>
											<td>:</td>
											<td><input type="date" class="form-control" id="var_tgl_penawaran" name="var_tgl_penawaran" data-options="required:true" value="<?php echo $tgl_penawaran ?>"></input></td>
										</tr>

										<tr>
											<td>Tanggal Akhir</td>
											<td>:</td>
											<td><input type="date" class="form-control" id="var_tgl_akhir" name="var_tgl_akhir" data-options="required:true" value="<?php echo $tgl_akhir ?>"></input></td>
										</tr>


										<tr>
											<td colspan='4'>
												<font color="red"><?php echo $err; ?></font>
											</td>
										</tr>
										<tr>
											<td colspan='4'><button type="submit" class="btn btn-info">Submit</button></td>
										</tr>
										</tr>
										<td>
											<font color="green"><?php echo $success ?></font>
										</td>
										</tr>
									</table>
								</form>
							</div>
						</section>
					</div>
				</div>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div>

	<?php include("lib/footers.php"); ?>
</body>

</html>